<?php

declare(strict_types=1);

namespace Medas\Core;

class Str implements \Stringable
{
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

            if ((string) $key != (string) $counter) {
                $retval .= self::fromVariable($key);
                $retval .= ': ';
            }

            $retval .= self::fromVariable($value);

            ++$counter;
        }

        $retval .= ']';

        return $retval;
    }

    public static function fromVariable(mixed $argument, bool $quotesOnlyAroundWhitespace = false): self
    {
        if (is_string($argument) && $argument !== '�') {
            if ($quotesOnlyAroundWhitespace) {
                if (preg_match('/\s/', $argument)) {
                    $argument = '"' . $argument . '"';
                }
            }
            else {
                $argument = '"' . $argument . '"';
            }
        }
        elseif (is_array($argument)) {
            $argument = self::fromArray($argument);
        }
        elseif (is_object($argument)) {
            $argument = self::fromObject($argument);
        }
        elseif (null === $argument) {
            $argument = 'NULL';
        }
        elseif (true === $argument) {
            $argument = 'TRUE';
        }
        elseif (false === $argument) {
            $argument = 'FALSE';
        }
        elseif (is_resource($argument)) {
            $argument = sprintf('resource:%s(%u)', get_resource_type($argument), (int) $argument);
        }

        return new self((string) $argument);
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

    private string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function truncateToByteLength(int $maxByteLength): self
    {
        if (strlen($this->string) <= $maxByteLength) {
            return $this;
        }

        // First, cut by character length
        $cutByCharacters = mb_substr($this->string, 0, $maxByteLength - 1);

        // Then, pop off single characters at the end until its *length in bytes* is good
        while (strlen($cutByCharacters) > $maxByteLength - 3) {
            $cutByCharacters = mb_substr($cutByCharacters, 0, -1);
        }

        // Append the ellipsis (three bytes long)
        $this->string = $cutByCharacters . '…';

        return $this;
    }

    public function truncateToCharLength(int $maxCharLength): self
    {
        if (count(mb_str_split($this->string)) > $maxCharLength) {
            $this->string = mb_substr($this->string, 0, $maxCharLength - 1) . '…';
        }

        return $this;
    }
}
