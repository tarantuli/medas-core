<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\{ManagedCollection, TracksChanges};

/** @template T */
class GenericCollection extends BasicCollection implements TracksChanges, ManagedCollection
{
    protected array $initialData = [];

    public function __construct(
        /** @var array<int, T> */
        protected array $data = [],
    )
    {
        // A freshly constructed collection has no persisted baseline, so its
        // entire content counts as additions. The data only becomes the baseline
        // once the collection is hydrated (setData) or persisted
        // (resetChangeTracking). Constructing with data therefore means "these
        // items are new", which is what a new entity's collection needs
        // to persist.
        $this->initialData = [];

        parent::__construct($data);
    }

    /**
     * Sets the data and resets change tracking.
     */
    public function setData(array $data): void
    {
        $this->data = $data;
        $this->initialData = $data;
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
            fn($value, $key)
                => !array_key_exists($key, $this->initialData) || $this->initialData[$key] !== $value
        );
    }

    /**
     * This uses value-based comparison, so it's best used for object collections.
     */
    public function getAdditions(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (!in_array($value, $this->initialData, true)) {
                yield $key => $value;
            }
        }
    }

    /**
     * This uses value-based comparison, so it's best used for object collections.
     */
    public function getDeletions(): iterable
    {
        foreach ($this->initialData as $key => $value) {
            if (!in_array($value, $this->data, true)) {
                yield $key => $value;
            }
        }
    }

    public function getMovements(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (in_array($value, $this->initialData, true)
                    && (!array_key_exists($key, $this->initialData) || $this->initialData[$key] !== $value)) {
                yield $key => $value;
            }
        }
    }

    public function getModifications(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (array_key_exists($key, $this->initialData) && $this->initialData[$key] !== $value) {
                yield $key => $value;
            }
        }
    }
}
