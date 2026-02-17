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
        $this->initialData = $data;

        parent::__construct($data);
    }

    public function setData(array $data): void
    {
        $this->data = $data;
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

    public function getModifications(): iterable
    {
        foreach ($this->data as $key => $value) {
            if (in_array($value, $this->initialData, true)
                    && (!array_key_exists($key, $this->initialData) || $this->initialData[$key] !== $value)) {
                yield $key => $value;
            }
        }
    }
}
