<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\{
    Attributes\ConfigValue,
    Attributes\Service,
    ConfigOptions\TraceArgumentMaxLength,
    StringMaker
};

/**
 * Turns the frames of a stack trace into readable text, the oldest call first, for error reports and logs.
 *
 * Each frame shows its file and line, or `[main]` when it has none, followed by the called method. Functions without a
 * class are shown as `[main]::name()`. Then come the arguments: objects as their class and object ID, arrays and other
 * non-scalars only as their type, and valid UTF-8 strings cut off at `core.trace-argument-max-length` characters. Other
 * strings and scalars are printed in full with `StringMaker`, which shows invalid bytes as hexadecimal.
 *
 * @see TraceArgumentMaxLength
 */
#[Service]
readonly class TraceFormatter
{
    private StringMaker $stringMaker;
    private StringMaker\Settings $settings;

    public function __construct(
        /** Valid UTF-8 strings in arguments are cut off at this many characters. */
        #[ConfigValue(TraceArgumentMaxLength::class)]
        private int $traceArgumentMaxLength,
    )
    {
        $this->stringMaker = StringMaker::instance();
        $this->settings = StringMaker\Settings::forDisplay();
    }

    /**
     * @param array[] $frames The frames as `\Throwable::getTrace()` returns them, most recent call first.
     */
    public function toString(array $frames): string
    {
        $output = '';

        foreach (array_reverse($frames) as $frame) {
            if (isset($frame['file'])) {
                $output .= sprintf("%s:%u\n", $frame['file'], $frame['line']);
            }
            else {
                $output .= "[main]\n";
            }

            $output .= sprintf("   %s::%s()\n", $frame['class'] ?? '[main]', $frame['function']);

            foreach ($frame['args'] ?? [] as $index => $argument) {
                $output .= sprintf('    %u: ', $index);
                $type = get_debug_type($argument);

                if (class_exists($type)) {
                    $output .= sprintf("%s[%u]\n", $type, spl_object_id($argument));
                }
                elseif (!is_scalar($argument)) {
                    $output .= sprintf("%s\n", $type);
                }
                elseif (is_string($argument) && mb_detect_encoding($argument, 'UTF-8', true)) {
                    $output .= sprintf(
                        "%s\n",
                        mb_substr($argument, 0, $this->traceArgumentMaxLength)
                    );
                }
                else {
                    $output .= sprintf(
                        "%s\n",
                        $this->stringMaker->fromVariable($argument, $this->settings)
                    );
                }
            }

            $output .= "\n";
        }

        return $output;
    }
}
