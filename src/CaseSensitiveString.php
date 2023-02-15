<?php

declare(strict_types=1);

namespace Medas\Core;

class CaseSensitiveString implements \Stringable
{
    public static function fromVariable(
        mixed $argument,
        bool  $quotesOnlyAroundWhitespace = false,
        bool  $forceUtf8 = false,
    ): static
    {
        return new static(StringMaker::fromVariable($argument, $quotesOnlyAroundWhitespace, $forceUtf8));
    }

    protected string $string;

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

    public function surroundedBy(string $needle): bool
    {
        return $this->startsWith($needle) && $this->endsWith($needle);
    }

    public function startsWith(string $needle): bool
    {
        return str_starts_with($this->string, $needle);
    }

    public function endsWith(string $needle): bool
    {
        return str_starts_with($this->string, $needle);
    }

    public function chopFromStart(string $needle): bool
    {
        if (!$this->startsWith($needle)) {
            return false;
        }

        $this->string = substr($this->string, strlen($needle));
        return true;
    }

    public function chopFromEnd(string $needle): bool
    {
        if (!$this->endsWith($needle)) {
            return false;
        }

        $this->string = substr($this->string, 0, -strlen($needle));
        return true;
    }

    public function contains(string $needle): bool
    {
        return str_contains($this->string, $needle);
    }

    public function equals(string $needle): bool
    {
        return $this->string === $needle;
    }

    public function regexMatch(string $pattern, int $flags = 0, int $offset = 0): array|null
    {
        $matched = preg_match($pattern, $this->string, $match, $flags, $offset);

        return $matched ? $match : null;
    }

    public function regexMatchAll(string $pattern, int $flags = PREG_SET_ORDER, int $offset = 0): array
    {
        $matched = preg_match_all($pattern, $this->string, $matches, $flags, $offset);

        return $matched ? $matches : [];
    }

    public function regexReplace(string $pattern, string $replacement, int $limit = -1): int
    {
        $this->string = preg_replace($pattern, $replacement, $this->string, $limit, $count);

        return $count;
    }
}
