<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks objects with an identifier, like entities.
 *
 * The global function `equalIds()` compares two of them by their identifiers as strings, so an integer `1` and a
 * string `'1'` are equal.
 */
interface HasId
{
    public function id(): mixed;
}
