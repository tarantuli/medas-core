<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * This should not be a service and should not contain static properties.
 * Both requirements help with making this class as independent and low-level as possible,
 * so it can be used reliably in core processes like exception handling.
 */
class StringMaker
{
    public static function fromArray(array $argument): string
    {
        if (count(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)) >= 25) {
            return '�';
        }

        $retval = '[';
        $counter = 0;

        foreach ($argument as $key => $value) {
            if ($counter > 0) {
                $retval .= ', ';
            }

            if ((string) $key !== (string) $counter) {
                $retval .= self::fromVariable($key);
                $retval .= ': ';
            }

            $retval .= self::fromVariable($value);

            ++$counter;
        }

        $retval .= ']';

        return $retval;
    }

    public static function fromVariable(
        mixed $argument,
        bool  $quotesOnlyAroundWhitespace = false,
        bool  $forceUtf8 = false,
    ): string
    {
        if (is_string($argument)) {
            if ($argument === '�' || ($quotesOnlyAroundWhitespace && !preg_match('/\s/', $argument))) {
                $string = $argument;
            }
            else {
                $string = '"' . $argument . '"';
            }
        }
        elseif (is_array($argument)) {
            $string = self::fromArray($argument);
        }
        elseif (is_object($argument)) {
            $string = self::fromObject($argument);
        }
        elseif (null === $argument) {
            $string = 'NULL';
        }
        elseif (true === $argument) {
            $string = 'TRUE';
        }
        elseif (false === $argument) {
            $string = 'FALSE';
        }
        elseif (is_resource($argument)) {
            $string = sprintf('resource:%s(%u)', get_resource_type($argument), (int) $argument);
        }
        else {
            $string = (string) $argument;
        }

        if ($forceUtf8) {
            $string = self::forceUtf8($string);
        }

        return $string;
    }

    public static function fromObject(object $argument): string
    {
        $retval = get_class($argument);
        $retval .= '(';
        $firstValue = true;
        $vars = get_object_vars($argument);

        $class = new \ReflectionClass($argument);

        if ($class->hasProperty('id')) {
            $property = $class->getProperty('id');

            if ($property->isInitialized($argument)) {
                $vars['id'] = $property->getValue($argument);
            }
            else {
                $vars['id'] = '�';
            }
        }

        foreach ($vars as $key => $value) {
            if (!$firstValue) {
                $retval .= ', ';
            }

            $retval .= self::fromVariable($key);
            $retval .= ': ';
            $retval .= self::fromVariable($value);
            $firstValue = false;
        }

        $retval .= ')';

        return $retval;
    }

    public static function forceUtf8(string $string): string
    {
        $result = '';

        foreach (mb_str_split($string) as $char) {
            if (mb_check_encoding($char, 'UTF-8')) {
                $result .= $char;
            }
            else {
                $result .= '▪' . str_pad(dechex(ord($char)), 2, '0', STR_PAD_LEFT);
            }
        }

        return $result;
    }
}
