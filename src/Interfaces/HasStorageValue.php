<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A value object that's stored as a single scalar, rather than as the array a
 * @class(Medas\Core\Attributes\DataHolder) is normally stored as, so it can be compared for equality and range in the
 * database.
 *
 * The storage manager stores what `toStorageValue()` returns, and turns it back with `fromStorageValue()` when the
 * property is typed with @class(Medas\Core\Types\DataHolder) for this class.
 *
 * @assumes The stored form sorts in the value's natural order. A year and month, for example, can be stored as a
 *          fixed-width `'yyyymm'`, where text order matches chronological order.
 */
interface HasStorageValue
{
    /**
     * @param mixed $value What `toStorageValue()` returned, as storage gives it back
     */
    public static function fromStorageValue(mixed $value): static;

    /**
     * @return mixed A scalar
     */
    public function toStorageValue(): mixed;
}
