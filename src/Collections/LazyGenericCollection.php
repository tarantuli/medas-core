<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

/**
 * @template T
 * @extends GenericCollection<T>
 */
class LazyGenericCollection extends GenericCollection
{
    private bool $hasFetched = false;

    public function __construct(
        private readonly \Closure $fetcher,
    )
    {
        parent::__construct();
    }

    private function check(): void
    {
        if (!$this->hasFetched) {
            $this->data = ($this->fetcher)();
            $this->additions = array_values($this->data);

            $this->hasFetched = true;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        $this->check();
        return parent::offsetExists($offset);
    }

    /**
     * @param int $offset
     *
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        $this->check();
        return parent::offsetGet($offset);
    }

    /**
     * @param int $offset
     * @param T   $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->check();
        parent::offsetSet($offset, $value);
    }

    /**
     * @param int $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->check();
        parent::offsetUnset($offset);
    }

    /** @return T */
    public function current(): mixed
    {
        $this->check();
        return parent::current();
    }

    public function valid(): bool
    {
        $this->check();
        return parent::valid();
    }

    public function count(): int
    {
        $this->check();
        return parent::count();
    }

    public function getAdditions(): array
    {
        $this->check();
        return parent::getAdditions();
    }

    public function getDeletions(): array
    {
        $this->check();
        return parent::getDeletions();
    }

    public function resetChangeTracking(): void
    {
        $this->check();
        parent::resetChangeTracking();
    }
}
