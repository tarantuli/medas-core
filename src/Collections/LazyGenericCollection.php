<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\{Exceptions\NoInitializerHasBeenSet, Interfaces\IsLazyLoaded};

/**
 * @template T
 * @extends GenericCollection<T>
 */
class LazyGenericCollection extends GenericCollection implements IsLazyLoaded
{
    private bool $hasFetched = false;
    private \Closure|null $fetcher;

    public function __construct(\Closure|null $loader = null)
    {
        $this->fetcher = $loader;

        parent::__construct();
    }

    public function setData(array $data): void
    {
        $this->hasFetched = true;

        parent::setData($data);
    }

    public function setLoader(callable $loader): void
    {
        $this->fetcher = $loader;
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

    public function getAdditions(): iterable
    {
        $this->check();

        return parent::getAdditions();
    }

    public function getDeletions(): iterable
    {
        $this->check();

        return parent::getDeletions();
    }

    public function resetChangeTracking(): void
    {
        $this->check();

        parent::resetChangeTracking();
    }

    public function values(): iterable
    {
        $this->check();

        return parent::values();
    }

    public function contains(mixed $value): bool
    {
        $this->check();

        return parent::contains($value);
    }

    public function rewind(): void
    {
        $this->check();

        parent::rewind();
    }

    public function next(): void
    {
        $this->check();

        parent::next();
    }

    public function key(): int|string|null
    {
        $this->check();

        return parent::key();
    }

    public function getModifications(): iterable
    {
        $this->check();

        return parent::getModifications();
    }

    public function getMovements(): iterable
    {
        $this->check();

        return parent::getMovements();
    }

    private function check(): void
    {
        if (!$this->hasFetched) {
            if ($this->fetcher === null) {
                throw new NoInitializerHasBeenSet();
            }

            $this->initialData = $this->data = ($this->fetcher)();
            $this->hasFetched = true;
        }
    }
}
