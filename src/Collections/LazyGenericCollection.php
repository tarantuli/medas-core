<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\Interfaces\IsLazyLoaded;

/**
 * @template T
 * @extends GenericCollection<T>
 */
class LazyGenericCollection extends GenericCollection implements IsLazyLoaded
{
    private bool $hasFetched = false;
    private \Closure $fetcher;

    public function __construct(\Closure $loader = null)
    {
        if ($loader instanceof \Closure) {
            $this->fetcher = $loader;
        }

        parent::__construct();
    }

    public function setLoader(callable $loader): void
    {
        $this->fetcher = $loader;
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
