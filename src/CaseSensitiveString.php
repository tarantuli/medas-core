<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * An immutable string with helper methods. Methods that change the string return a new object. Comparisons are
 * case-sensitive; @class(Medas\Core\CaseInsensitiveString) compares without case.
 *
 * Lengths in characters count UTF-8 characters.
 */
readonly class CaseSensitiveString implements \Stringable
{
    /**
     * Creates one from any value, written as `StringMaker::fromVariable()` writes it.
     *
     * @param bool $quotesOnlyAroundWhitespace Only puts strings in quotes when they're empty or contain whitespace.
     * @param bool $forceUtf8                  Replaces invalid UTF-8 bytes; see `StringMaker::forceUtf8()`.
     */
    public static function fromVariable(
        mixed $argument,
        bool  $quotesOnlyAroundWhitespace = false,
        bool  $forceUtf8 = false,
    ): static
    {
        return new static(StringMaker::instance()->fromVariable(
            $argument,
            new StringMaker\Settings($quotesOnlyAroundWhitespace, $forceUtf8)
        ));
    }

    public function __construct(
        public string $value,
    )
    {
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Returns the string cut to at most `$maxByteLength` bytes, ending in `…`, which takes 3 bytes, when it was cut.
     * It's cut between characters, never inside one.
     *
     * @throws Exceptions\TruncationLengthTooShort When `$maxByteLength` is less than 4.
     */
    public function truncateToByteLength(int $maxByteLength): self
    {
        // Leaves room for the ellipsis and at least one byte of the string
        if ($maxByteLength < 4) {
            throw new Exceptions\TruncationLengthTooShort($maxByteLength);
        }

        if (strlen($this->value) <= $maxByteLength) {
            return clone $this;
        }

        // First, cut by character length
        $cutByCharacters = mb_substr($this->value, 0, $maxByteLength - 1);

        // Then, pop off single characters at the end until its *length in bytes* is good
        while (strlen($cutByCharacters) > $maxByteLength - 3) {
            $cutByCharacters = mb_substr($cutByCharacters, 0, -1);
        }

        // Append the ellipsis (three bytes long)
        return new static($cutByCharacters . '…');
    }

    /**
     * Returns the string cut to at most `$maxCharLength` characters, the last of which is `…` when it was cut.
     *
     * @throws Exceptions\TruncationLengthTooShort When `$maxCharLength` is less than 4.
     */
    public function truncateToCharLength(int $maxCharLength): self
    {
        if ($maxCharLength < 4) {
            throw new Exceptions\TruncationLengthTooShort($maxCharLength);
        }

        if (count(mb_str_split($this->value)) > $maxCharLength) {
            return new static(mb_substr($this->value, 0, $maxCharLength - 1) . '…');
        }

        return $this;
    }

    /**
     * Returns the string padded to `$length` characters with `$padString`, like `str_pad()` does, but counting
     * characters instead of bytes. With `STR_PAD_BOTH`, the left side gets the smaller half.
     *
     * @throws Exceptions\PadStringCannotBeEmpty When `$padString` is `''`.
     */
    public function padToCharLength(int $length, string $padString = ' ', int $type = STR_PAD_RIGHT): self
    {
        $padStringLength = mb_strlen($padString);

        if ($padStringLength === 0) {
            throw new Exceptions\PadStringCannotBeEmpty();
        }

        $missing = $length - mb_strlen($this->value);

        if ($missing <= 0) {
            return clone $this;
        }

        $repeated = str_repeat($padString, (int) ceil($missing / $padStringLength));

        return match ($type) {
            STR_PAD_LEFT => new static(mb_substr($repeated, 0, $missing) . $this->value),

            STR_PAD_BOTH
                => new static(mb_substr($repeated, 0, (int) floor($missing / 2)) . $this->value . mb_substr(
                    $repeated,
                    0,
                    (int) ceil($missing / 2)
                )),

            default => new static($this->value . mb_substr($repeated, 0, $missing)),
        };
    }

    /**
     * Returns `true` when the string starts and ends with `$needle`. A string that's just `$needle` once counts too.
     */
    public function surroundedBy(string $needle): bool
    {
        return $this->startsWith($needle) && $this->endsWith($needle);
    }

    public function startsWith(string $needle): bool
    {
        return str_starts_with($this->value, $needle);
    }

    public function endsWith(string $needle): bool
    {
        return str_ends_with($this->value, $needle);
    }

    /**
     * Returns the string without `$needle` at its start, removed once, or unchanged when it doesn't start with it.
     *
     * @throws Exceptions\ChopStringCannotBeEmpty When `$needle` is `''`.
     */
    public function chopFromStart(string $needle): self
    {
        if ($needle === '') {
            throw new Exceptions\ChopStringCannotBeEmpty();
        }

        if (!$this->startsWith($needle)) {
            return clone $this;
        }

        return new static(substr($this->value, strlen($needle)));
    }

    /**
     * Returns the string without `$needle` at its end, removed once, or unchanged when it doesn't end with it.
     *
     * @throws Exceptions\ChopStringCannotBeEmpty When `$needle` is `''`.
     */
    public function chopFromEnd(string $needle): self
    {
        if ($needle === '') {
            throw new Exceptions\ChopStringCannotBeEmpty();
        }

        if (!$this->endsWith($needle)) {
            return clone $this;
        }

        return new static(substr($this->value, 0, -strlen($needle)));
    }

    public function contains(string $needle): bool
    {
        return str_contains($this->value, $needle);
    }

    public function equals(string $needle): bool
    {
        return $this->value === $needle;
    }

    /**
     * Returns the matches of `preg_match()`, or `null` when nothing matches or the pattern fails.
     */
    public function regexMatch(string $pattern, int $flags = 0, int $offset = 0): array|null
    {
        $matched = preg_match($pattern, $this->value, $match, $flags, $offset);

        return $matched ? $match : null;
    }

    /**
     * Returns the matches of `preg_match_all()`, grouped per match by default, or `[]` when nothing matches or the
     * pattern fails.
     */
    public function regexMatchAll(string $pattern, int $flags = PREG_SET_ORDER, int $offset = 0): array
    {
        $matched = preg_match_all($pattern, $this->value, $matches, $flags, $offset);

        return $matched ? $matches : [];
    }

    /**
     * Returns the string with `preg_replace()` applied. Before version 2.1.0, it returned the number of replacements
     * instead.
     *
     * @throws Exceptions\RegexReplaceFailed When the replacement fails, for example because the pattern is invalid.
     */
    public function regexReplace(string $pattern, string $replacement, int $limit = -1): self
    {
        $result = preg_replace($pattern, $replacement, $this->value, $limit);

        if ($result === null) {
            throw new Exceptions\RegexReplaceFailed(
                $this->value,
                $pattern,
                $replacement,
                preg_last_error_msg()
            );
        }

        return new static($result);
    }
}
