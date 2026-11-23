<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

/**
 * Groups values by an index, like values by date or by score, and returns the group at the highest or lowest index,
 * or the largest or smallest group.
 *
 * Indexes keep the order in which they were first added. When two groups are equally large, `atMaxCount()` and
 * `atMinCount()` return the first one.
 *
 * @notFor A list of values; despite its name it doesn't implement @class(Medas\Core\Interfaces\Collection).
 */
class ArrayCollection
{
    private array $perIndex = [];
    private array $indexes = [];

    public function add(mixed $index, mixed $value): void
    {
        if (!array_key_exists($index, $this->perIndex)) {
            $this->perIndex[$index] = [];
            $this->indexes[] = $index;
        }

        $this->perIndex[$index][] = $value;
    }

    /**
     * Returns the values added under `$index`, or `null` when there are none.
     */
    public function atIndex(mixed $index): array|null
    {
        return $this->perIndex[$index] ?? null;
    }

    /**
     * Returns the values under the highest index, or `null` when the collection is empty.
     *
     * @assumes The indexes can be compared with `max()`, like numbers or dates written the same way.
     */
    public function atMaxIndex(): array|null
    {
        if (empty($this->indexes)) {
            return null;
        }

        return $this->perIndex[max($this->indexes)];
    }

    /**
     * Returns the values under the lowest index, or `null` when the collection is empty.
     *
     * @assumes The indexes can be compared with `min()`.
     */
    public function atMinIndex(): array|null
    {
        if (empty($this->indexes)) {
            return null;
        }

        return $this->perIndex[min($this->indexes)];
    }

    /**
     * Returns the largest group, or `null` when the collection is empty.
     */
    public function atMaxCount(): array|null
    {
        $maxCount = null;
        $atMaxCount = null;

        foreach ($this->perIndex as $values) {
            $count = count($values);

            if ($maxCount === null || $count > $maxCount) {
                $maxCount = $count;
                $atMaxCount = $values;
            }
        }

        return $atMaxCount;
    }

    /**
     * Returns the smallest group, or `null` when the collection is empty.
     */
    public function atMinCount(): array|null
    {
        $minCount = null;
        $atMinCount = null;

        foreach ($this->perIndex as $values) {
            $count = count($values);

            if ($minCount === null || $count < $minCount) {
                $minCount = $count;
                $atMinCount = $values;
            }
        }

        return $atMinCount;
    }

    /**
     * The indexes, in the order in which they were first added.
     */
    public function indexes(): array
    {
        return $this->indexes;
    }
}
