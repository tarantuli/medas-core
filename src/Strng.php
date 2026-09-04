<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class Strng extends CaseSensitiveString
{
    public static function create(string $string): static
    {
        return new static($string);
    }
}
