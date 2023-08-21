<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A generic interface that combines \ArrayAccess, \Iterator and \Countable.
 *
 * Examples:
 *
 * - GenericCollection from medas/core.
 *
 * - LazyGenericCollection from medas/core is a collection that only calls its fetcher when data is actually read.
 *
 * @template T
 */
interface Collection extends \ArrayAccess, \Iterator, \Countable
{
    /** @return T */
    public function offsetGet(mixed $offset): mixed;

    /**  @param T $value */
    public function offsetSet(mixed $offset, mixed $value): void;

    /** @return T */
    public function current(): mixed;
}
