<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\{ManagedCollection, SettableCollection, TracksChanges};

/** @template T */
class GenericCollection implements TracksChanges, ManagedCollection, SettableCollection
{
    protected int $index = 0;
    protected array $initialData = [];

    public function __construct(
        /** @var array<int, T> */
        protected array $data = [],
    )
    {
        $this->initialData = $data;
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
        $this->initialData = $this->data;
    }

    public function hasChanged(): bool
    {
        if (count($this->initialData) !== count($this->data)) {
            return true;
        }

        return array_any(
            $this->data,
            fn($value, $key) => !array_key_exists($key, $this->initialData)
                || $this->initialData[$key] !== $value
        );
    }

    public function getAdditions(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (!in_array($value, $this->initialData, true)) {
                yield $key => $value;
            }
        }
    }

    public function getDeletions(): iterable
    {
        foreach ($this->initialData as $key => $value) {
            if (!in_array($value, $this->data, true)) {
                yield $key => $value;
            }
        }
    }

    public function contains(mixed $value): bool
    {
        return in_array($value, $this->data, true);
    }

    public function getModifications(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (in_array($value, $this->initialData, true) && $this->initialData[$key] !== $value) {
                yield $key => $value;
            }
        }
    }
}
