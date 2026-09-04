<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class Strng extends CaseSensitiveString
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}
