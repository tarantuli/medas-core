<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A list of values that works like an array: it can be read and written by key, iterated over and counted. It also
 * says whether it contains a value, and removes one.
 *
 * Entities use collections for their to-many relations, so storage can track and load the items.
 *
 * Examples:
 *
 * - @class(Medas\Core\Collections\GenericCollection) tracks its additions, deletions and other changes.
 * - @class(Medas\Core\Collections\LazyGenericCollection) only calls its loader when its data is first read.
 *
 * @template T
 * @see SettableCollection
 * @see ManagedCollection
 */
interface Collection extends \ArrayAccess, \Iterator, \Countable
{
    /** @return T */
    public function offsetGet(mixed $offset): mixed;

    /**
     * With a `null` offset, as in `$collection[] = $value`, the value is added at the end.
     *
     * @param T $value
     */
    public function offsetSet(mixed $offset, mixed $value): void;

    /** @return T */
    public function current(): mixed;

    /**
     * Whether the collection holds `$value`. Values are compared strictly, so an object is only found as the same
     * instance.
     *
     * @param T $value
     */
    public function contains(mixed $value): bool;

    /**
     * Removes the first occurrence of `$value`, compared strictly, and returns whether it was there.
     *
     * @param T $value
     */
    public function remove(mixed $value): bool;
}
