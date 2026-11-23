<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\{ManagedCollection, TracksChanges};

/**
 * A collection that tracks what changed since its baseline, as @class(Medas\Core\Interfaces\ManagedCollection)
 * describes. Entities use it for their to-many relations.
 *
 * A collection created with data has an empty baseline, so all its items count as additions: that's what a new
 * entity's collection needs to be stored. `setData()` and `resetChangeTracking()` make the current content the
 * baseline, which storage does after loading and after storing the collection.
 *
 * @state Keeps a copy of the baseline next to the data. Both are serialised, so a copy from a cache still knows what
 *        changed.
 * @notFor Collections of scalars that can occur more than once: additions and deletions compare values, not
 *         positions, so adding a second copy of a value that's already in the baseline isn't an addition.
 * @template T
 */
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

    public function __serialize(): array
    {
        return [
            'data' => $this->data,
            'initialData' => $this->initialData,
        ];
    }

    public function __unserialize(array $data): void
    {
        // A collection serialised before the baseline was stored holds only its data. Its items then count as new,
        // as they did before.
        if (array_keys($data) !== ['data', 'initialData']) {
            $this->data = $data;
            $this->initialData = [];

            return;
        }

        $this->data = $data['data'];
        $this->initialData = $data['initialData'];
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
