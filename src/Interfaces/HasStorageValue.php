<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A value object that stores itself as a single scalar - rather than the generic
 * DataHolder array - so it can be compared for equality and range in the
 * database. The stored form must sort in the value's natural order (e.g., a
 * YearMonth as a fixed-width "yyyymm", where lexical order matches chronological
 * order).
 */
interface HasStorageValue
{
    public function toStorageValue(): mixed;

    public static function fromStorageValue(mixed $value): static;
}
