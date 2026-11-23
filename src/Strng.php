<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A shorter name for @class(Medas\Core\CaseSensitiveString), with `create()` to start a chain of calls:
 * `Strng::create($path)->chopFromEnd('/')`.
 */
readonly class Strng extends CaseSensitiveString
{
    /**
     * Creates one, like the constructor does.
     */
    public static function create(string $value): static
    {
        return new static($value);
    }
}
