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

    /**
     * Turns the given array into a human-readable single string.
     */
    public function fromArray(array $argument, StringMaker\Settings $settings = null): string
    {
        $settings ??= new StringMaker\Settings();

        if (count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)) >= 100) {
            return '�';
        }

        $retval = '[';
        $counter = 0;

        foreach ($argument as $key => $value) {
            if ($counter > 0) {
                $retval .= ', ';
            }

            if ((string) $key !== (string) $counter) {
                $retval .= $this->fromVariable($key, $settings);
                $retval .= ': ';
            }

            $retval .= $this->fromVariable($value, $settings);

            ++$counter;
        }

        $retval .= ']';

        return $retval;
    }

    /**
     * Turns the given variable into a human-readable single string.
     */
    public function fromVariable(mixed $argument, StringMaker\Settings $settings = null): string
    {
        $settings ??= new StringMaker\Settings();

        if (is_string($argument)) {
            if ($argument === '�') {
                $string = $argument;
            }
            elseif ($settings->quotesOnlyAroundWhitespace && $argument !== '' && !preg_match('/\s/u', $argument)) {
                $string = $argument;
            }
            else {
                $string = '"' . $argument . '"';
            }
        }
        elseif (is_array($argument)) {
            $string = $this->fromArray($argument, $settings);
        }
        elseif (is_object($argument)) {
            $string = $this->fromObject($argument, $settings);
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
            $string = $this->forceUtf8($string);
        }

        return $string;
    }

    /**
     * Turns the given object into a human-readable single string.
     */
    public function fromObject(object $argument, StringMaker\Settings $settings = null): string
    {
        if ($argument instanceof \Stringable) {
            return (string) $argument;
        }

        $settings ??= new StringMaker\Settings();
        $retval = get_class($argument);
        $retval .= '(';
        $firstValue = true;
        $vars = get_object_vars($argument);
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

            $retval .= $this->fromVariable($key, $settings);
            $retval .= ': ';
            $retval .= $this->fromVariable($value, $settings);
            $firstValue = false;
        }

        $retval .= ')';

        return $retval;
    }

    /**
     * Turns the given string into a human-readable single string that's valid UTF-8 by replacing non-valid bytes by a
     * "▪" followed by a hexadecimal representation of the byte value.
     */
    public function forceUtf8(string $string): string
    {
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

    public function fromPattern(string $pattern, array $arguments): string
    {
        $settings = new StringMaker\Settings(true, true);

        foreach ($arguments as &$argument) {
            try {
                $string = new CaseSensitiveString($this->fromVariable($argument, $settings));
                $argument = $string->truncateToCharLength(1000);
            }
            catch (\Exception) {
                $argument = '�';
            }
        }

        return vsprintf($pattern, $arguments);
    }
}
