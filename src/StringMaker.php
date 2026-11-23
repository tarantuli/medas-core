<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Turns any value into readable text, for messages, logs and error reports. Exception messages are made with
 * `fromPattern()`.
 *
 * Nested values are followed to a depth of 100 steps, each nested array or object taking two. Deeper values are
 * written as `�`.
 *
 * It isn't a service, on purpose: it has to work anywhere, including while an exception is being handled, so it
 * depends on nothing else. For the same reason, its limits are fixed instead of configurable, since reading the
 * configuration would need services. Get it with `StringMaker::instance()`, or create one.
 */
class StringMaker
{
    use AsSingleton;

    /** The recursion depth at which a placeholder is returned instead. Every nested array or object takes two steps. */
    private const int MAX_DEPTH = 100;

    /** The default maximum number of characters of each argument in `fromPattern()`. */
    private const int MAX_STRING_LENGTH = 1000;

    /**
     * Public, unlike the constructor `AsSingleton` provides, so a `StringMaker` can also be created directly.
     */
    public function __construct()
    {
    }

    /**
     * Writes an array as `[1, 2]`. A key is only written, as `key: value`, where it differs from the item's position:
     * `['x' => 1, 2]` becomes `["x": 1, 0: 2]`.
     */
    public function fromArray(array $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= self::MAX_DEPTH) {
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
     * Writes any value on a single line:
     *
     * - A string as it is, in quotes. With `Settings::$quotesOnlyAroundWhitespace`, only an empty string or one
     *   containing whitespace gets quotes.
     * - `null`, `true` and `false` as words, and other scalars as PHP casts them to a string.
     * - Arrays as `fromArray()` writes them, and objects as `fromObject()` writes them.
     * - A resource as `resource:type(id)`.
     *
     * With `Settings::$forceUtf8`, the result is passed through `forceUtf8()`. A string that comes out as a
     * hexadecimal dump isn't put in quotes.
     */
    public function fromVariable(mixed $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= self::MAX_DEPTH) {
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

        // Too much binary to read becomes a hex dump, which is not a string value: no quotes
        $isHexDump = is_string($argument) && $string === '0x' . bin2hex($argument);

        if (is_string($argument)
                && !$isHexDump
                && $string !== '�'
                && (!$settings->quotesOnlyAroundWhitespace || $string === '' || preg_match('/\s/u', $string))) {
            $string = '"' . $string . '"';
        }

        return $string;
    }

    /**
     * Writes an object as its class, its ID and its data: `Foo[12](a: 1, id: 7)`.
     *
     * The data is what `__serialize()` returns, or else the public properties. The properties `id` and `name` are
     * always added, even when they're not public, or `�` when they aren't initialised yet. A `\Stringable` object is
     * written as its string instead, with its class and ID in front only with `Settings::$alwaysAddClass`, like
     * `Foo[12]<text>`.
     */
    public function fromObject(object $argument, StringMaker\Settings|null $settings = null, int $depth = 0): string
    {
        if ($depth >= self::MAX_DEPTH) {
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
     * Makes a string valid UTF-8 by replacing each invalid byte with `▪` and its value in hexadecimal, like `▪ff`.
     *
     * When more than a tenth of the characters are invalid, the whole string is written in hexadecimal instead, like
     * `0xfffe6162`.
     */
    public function forceUtf8(string $string, int $depth = 0): string
    {
        if ($depth >= self::MAX_DEPTH) {
            return '�';
        }

        $result = '';
        $replacements = 0;
        $characters = $this->utf8CharactersOrBytes($string);

        foreach ($characters as $char) {
            if (mb_check_encoding($char, 'UTF-8')) {
                $result .= $char;
            }
            else {
                $result .= '▪' . bin2hex($char);

                ++$replacements;
            }
        }

        if ($replacements > 0.1 * count($characters)) {
            return '0x' . bin2hex($string);
        }

        return $result;
    }

    /**
     * Splits a string into valid UTF-8 characters and, between them, single stray bytes.
     * mb_str_split() cannot be used: it takes a lead byte's full expected length, so a
     * truncated character swallows the valid characters after it.
     *
     * @return string[]
     */
    private function utf8CharactersOrBytes(string $string): array
    {
        preg_match_all(
            '/[\x00-\x7F]'
                . '|[\xC2-\xDF][\x80-\xBF]'
                . '|\xE0[\xA0-\xBF][\x80-\xBF]|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}|\xED[\x80-\x9F][\x80-\xBF]'
                . '|\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2}'
                . '|[\x80-\xFF]/',
            $string,
            $matches
        );

        return $matches[0];
    }

    /**
     * Fills the values into `$pattern` with `vsprintf()`. Each value is first written as `fromVariable()` writes it,
     * with quotes only where needed and only valid UTF-8, and cut to `$maxStringLength` characters, 1000 by default.
     * A value that can't be written becomes `�`.
     *
     * @throws \ValueError When `$pattern` isn't a valid format, or has more placeholders than there are values.
     */
    public function fromPattern(
        string   $pattern,
        array    $arguments,
        int      $depth = 0,
        int|null $maxStringLength = null
    ): string
    {
        if ($depth >= self::MAX_DEPTH) {
            return '�';
        }

        $settings = new StringMaker\Settings(true, true);

        foreach ($arguments as &$argument) {
            try {
                $argument = (string) new CaseSensitiveString($this->fromVariable($argument, $settings, $depth + 1))
                    ->truncateToCharLength($maxStringLength ?? self::MAX_STRING_LENGTH);
            }
            catch (\Exception) {
                $argument = '�';
            }
        }

        return vsprintf($pattern, $arguments);
    }
}
