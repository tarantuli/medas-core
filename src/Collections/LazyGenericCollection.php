<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

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
            $this->hasFetched = true;
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        $this->check();
        return parent::offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        $this->check();
        return parent::offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->check();
        parent::offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->check();
        parent::offsetUnset($offset);
    }

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
}
