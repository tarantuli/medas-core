<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\Collection;
use Medas\Core\Interfaces\TracksChanges;

/**
 * @template T
 */
class GenericCollection implements Collection, TracksChanges
{
    private int $index = 0;
    private bool $hasChanged = false;

    public function __construct(
        /** @var array<int, T> */
        private array $data = [],
    )
    {
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    /**
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
        if ($offset === null
            || !array_key_exists($offset, $this->data)
            || $this->data[$offset] !== $value) {
            $this->data[] = $value;
            $this->hasChanged = true;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (array_key_exists($offset, $this->data)) {
            unset($this->data[$offset]);
            $this->hasChanged = true;
        }
    }

    /** @return T */
    public function current(): mixed
    {
        return $this->data[$this->index];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return array_key_exists($this->index, $this->data);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function resetChangeTracking(): void
    {
        $this->hasChanged = false;
    }

    public function hasChanged(): bool
    {
        return $this->hasChanged;
    }
}
