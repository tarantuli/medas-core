<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

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

    public function atIndex(mixed $index): array|null
    {
        return $this->perIndex[$index] ?? null;
    }

    public function atMaxIndex(): array
    {
        return $this->perIndex[max($this->indexes)];
    }

    public function atMinIndex(): array
    {
        return $this->perIndex[min($this->indexes)];
    }

    public function atMaxCount(): array
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

    public function atMinCount(): array
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

    public function indexes(): array
    {
        return $this->indexes;
    }
}
