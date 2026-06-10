<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * This class should not be a service; keep it as independent and low-level as possible, so it can be used reliably in
 * core processes like exception handling.
 */
class StringMaker
{
    use AsSingleton;

    public function __construct(
        #[Attributes\ConfigValue(ConfigOptions\StringMakerMaxDepth::class)]
        private readonly int $maxDepth = 100,

        #[Attributes\ConfigValue(ConfigOptions\StringMakerMaxStringLength::class)]
        private readonly int $maxStringLength = 1000,
    )
    {
    }

    /**
     * Turns the given array into a human-readable single string.
     */
    public function fromArray(array $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= $this->maxDepth) {
            return '�';
        }

        $settings ??= new StringMaker\Settings();
        $retval = '[';
        $counter = 0;

        foreach ($argument as $key => $value) {
            if ($counter > 0) {
                $retval .= ', ';
            }

            if ((string) $key !== (string) $counter) {
                $retval .= $this->fromVariable($key, $settings, $depth + 1);
                $retval .= ': ';
            }

            $retval .= $this->fromVariable($value, $settings, $depth + 1);

            ++$counter;
        }

        $retval .= ']';

        return $retval;
    }

    /**
     * Turns the given variable into a human-readable single string.
     */
    public function fromVariable(mixed $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= $this->maxDepth) {
            return '�';
        }

        $settings ??= new StringMaker\Settings();

        if (is_string($argument)) {
            $string = $argument;
        }
        elseif (is_array($argument)) {
            $string = $this->fromArray($argument, $settings, $depth + 1);
        }
        elseif (is_object($argument)) {
            $string = $this->fromObject($argument, $settings, $depth + 1);
        }
        elseif (null === $argument) {
            $string = 'null';
        }
        elseif (true === $argument) {
            $string = 'true';
        }
        elseif (false === $argument) {
            $string = 'false';
        }
        elseif (is_resource($argument)) {
            $string = sprintf('resource:%s(%u)', get_resource_type($argument), (int) $argument);
        }
        else {
            $string = (string) $argument;
        }

        if ($settings->forceUtf8) {
            $string = $this->forceUtf8($string, $depth + 1);
        }

        if (is_string($argument)
                && $string !== '�'
                && (!$settings->quotesOnlyAroundWhitespace || $string === '' || preg_match('/\s/u', $string))) {
            $string = '"' . $string . '"';
        }

        return $string;
    }

    /**
     * Turns the given object into a human-readable single string.
     */
    public function fromObject(object $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= $this->maxDepth) {
            return '�';
        }

        $settings ??= new StringMaker\Settings();

        if ($argument instanceof \Stringable) {
            if (!$settings->alwaysAddClass) {
                return (string) $argument;
            }

            if ($settings->useObjectIds) {
                return sprintf("%s[%s]<%s>", $argument::class, spl_object_id($argument), $argument);
            }
            else {
                return sprintf("%s<%s>", $argument::class, $argument);
            }
        }

        $retval = $argument::class;

        if ($settings->useObjectIds) {
            $retval .= sprintf('[%s](', spl_object_id($argument));
        }
        else {
            $retval .= '(';
        }

        $firstValue = true;

        if (method_exists($argument, '__serialize')) {
            $vars = $argument->__serialize();
        }
        else {
            $vars = get_object_vars($argument);
        }

        $class = new \ReflectionClass($argument);

        foreach (['id', 'name'] as $propertyName) {
            if ($class->hasProperty($propertyName)) {
                $property = $class->getProperty($propertyName);

                if ($property->isInitialized($argument)) {
                    $vars[$propertyName] = $property->getValue($argument);
                }
                else {
                    $vars[$propertyName] = '�';
                }
            }
        }

        foreach ($vars as $key => $value) {
            if (!$firstValue) {
                $retval .= ', ';
            }

            $retval .= $this->fromVariable($key, $settings, $depth + 1);
            $retval .= ': ';
            $retval .= $this->fromVariable($value, $settings, $depth + 1);
            $firstValue = false;
        }

        $retval .= ')';

        return $retval;
    }

    /**
     * Turns the given string into a human-readable single string that's valid UTF-8 by replacing non-valid bytes by a
     * "▪" followed by a hexadecimal representation of the byte value.
     */
    public function forceUtf8(string $string, int $depth = 0): string
    {
        if ($depth >= $this->maxDepth) {
            return '�';
        }

        $result = '';
        $replacements = 0;

        foreach (mb_str_split($string) as $char) {
            if (mb_check_encoding($char, 'UTF-8')) {
                $result .= $char;
            }
            else {
                $result .= '▪' . str_pad(dechex(ord($char)), 2, '0', STR_PAD_LEFT);

                ++$replacements;
            }
        }

        if ($replacements > 0.1 * mb_strlen($string)) {
            return '0x' . bin2hex($string);
        }

        return $result;
    }

    public function fromPattern(string $pattern, array $arguments, int $depth = 0): string
    {
        if ($depth >= $this->maxDepth) {
            return '�';
        }

        $settings = new StringMaker\Settings(true, true);

        foreach ($arguments as &$argument) {
            try {
                $string = new CaseSensitiveString($this->fromVariable($argument, $settings, $depth + 1));
                $argument = $string->truncateToCharLength($this->maxStringLength);
            }
            catch (\Exception) {
                $argument = '�';
            }
        }

        return vsprintf($pattern, $arguments);
    }
}
