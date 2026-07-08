<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\{
    Attributes\ConfigValue,
    Attributes\Service,
    ConfigOptions\TraceArgumentMaxLength,
    StringMaker
};

#[Service]
readonly class TraceFormatter
{
    private StringMaker $stringMaker;
    private StringMaker\Settings $settings;

    public function __construct(
        #[ConfigValue(TraceArgumentMaxLength::class)]
        private int $traceArgumentMaxLength,
    )
    {
        $this->stringMaker = StringMaker::instance();
        $this->settings = StringMaker\Settings::forDisplay();
    }

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
                elseif (is_string($argument) && mb_detect_encoding($argument, 'UTF-8')) {
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
