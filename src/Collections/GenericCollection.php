<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\{ManagedCollection, SettableCollection, TracksChanges};

/** @template T */
class GenericCollection implements TracksChanges, ManagedCollection, SettableCollection
{
    protected int $index = 0;
    protected bool $hasChanged = false;
    protected array $additions = [];
    protected array $deletions = [];

    public function __construct(
        /** @var array<int, T> */
        protected array $data = [],
    )
    {
        $this->additions = array_values($this->data);
    }

    public function __serialize(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
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
        if ($offset === null) {
            // A new value, append to the end
            $this->data[] = $value;
            $this->additions[] = $value;
            $this->hasChanged = true;
        }
        elseif (!array_key_exists($offset, $this->data)) {
            // A new value with a given offset, put there
            $this->data[$offset] = $value;
            $this->additions[] = $value;
            $this->hasChanged = true;
        }
        elseif ($this->data[$offset] !== $value) {
            // An existing value is overwritten
            $this->deletions[] = $this->data[$offset];
            $this->data[$offset] = $value;
            $this->additions[] = $value;
            $this->hasChanged = true;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (array_key_exists($offset, $this->data)) {
            $this->deletions[] = $this->data[$offset];

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
        $this->additions = [];
        $this->deletions = [];
    }

    public function hasChanged(): bool
    {
        return $this->hasChanged;
    }

    public function getAdditions(): array
    {
        return $this->additions;
    }

    public function getDeletions(): array
    {
        return $this->deletions;
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->data, true);
    }
}
