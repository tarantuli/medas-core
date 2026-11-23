<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\Collection;

/**
 * A plain @class(Medas\Core\Interfaces\Collection) on top of an array, without change tracking.
 *
 * Values keep the key they were added under. Removing one leaves a gap, so the keys aren't renumbered.
 *
 * @state Iterates with the internal pointer of its array, so two loops over the same collection at the same time,
 *        like a `foreach` inside another one, interfere with each other. Use `values()` for the inner loop.
 * @see GenericCollection
 * @template T
 */
class BasicCollection implements Collection
{
    public function __construct(
        /** @var array<int, T> */
        protected array $data = [],
    )
    {
    }

    public function __serialize(): array
    {
        return $this->data;
    }

    public function __unserialize(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Yields the keys and values, without moving the collection's own pointer.
     */
    public function values(): iterable
    {
        foreach ($this->data as $key => $value) {
            yield $key => $value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @assumes The key exists. For a missing key, PHP warns and `null` is returned.
     *
     * @param int $offset
     *
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset];
    }

    /**
     * @param int $offset
     * @param T   $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            // A new value, append to the end
            $this->data[] = $value;
        }
        elseif (!array_key_exists($offset, $this->data)) {
            // A new value with a given offset, put there
            $this->data[$offset] = $value;
        }
        elseif ($this->data[$offset] !== $value) {
            // An existing value is overwritten
            $this->data[$offset] = $value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (array_key_exists($offset, $this->data)) {
            unset($this->data[$offset]);
        }
    }

    /** @return T */
    public function current(): mixed
    {
        return current($this->data);
    }

    public function next(): void
    {
        next($this->data);
    }

    public function key(): int|string|null
    {
        return key($this->data);
    }

    public function valid(): bool
    {
        return key($this->data) !== null;
    }

    public function rewind(): void
    {
        reset($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->data, true);
    }

    public function remove(mixed $value): bool
    {
        $key = array_search($value, $this->data, true);

        if ($key === false) {
            return false;
        }

        unset($this->data[$key]);

        return true;
    }
}
