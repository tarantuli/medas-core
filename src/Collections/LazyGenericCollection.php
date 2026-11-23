<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

use Medas\Core\{
    Exceptions\CannotSerializeUnloadedLazyCollection,
    Exceptions\NoInitializerHasBeenSet,
    Interfaces\IsLazyLoaded
};

/**
 * A @class(Medas\Core\Collections\GenericCollection) that only calls its loader when its content is first read or
 * changed, so a relation that's never used costs no query.
 *
 * Where the loader comes from decides what its items are:
 *
 * - A loader given to the constructor makes new items: they all count as additions, like the data given to a
 *   `GenericCollection`.
 * - A loader set with `setLoader()`, as storage does, loads the stored items: they're the baseline.
 *
 * `setData()` sets the content without calling the loader. `hasChanged()` only loads new items: stored items that
 * haven't been loaded can't have changed, but new items count as changed as soon as there are any.
 *
 * The loader can't be serialised, so only a collection whose content has been loaded can be serialised. The copy has
 * the content, and needs no loader.
 *
 * @throws NoInitializerHasBeenSet When the content is used, but there's neither a loader nor
 *                                                         data set with `setData()`.
 * @throws CannotSerializeUnloadedLazyCollection When the collection is serialised before its
 *                                                                       content has been loaded.
 * @template T
 * @extends GenericCollection<T>
 */
class LazyGenericCollection extends GenericCollection implements IsLazyLoaded
{
    private bool $hasFetched = false;
    private \Closure|null $fetcher;

    // Whether the loaded items are new rather than already persisted (see check())
    private bool $loadsNewItems;

    public function __construct(\Closure|null $loader = null)
    {
        $this->fetcher = $loader;
        $this->loadsNewItems = $loader !== null;

        parent::__construct();
    }

    public function __serialize(): array
    {
        if (!$this->hasFetched) {
            throw new CannotSerializeUnloadedLazyCollection(static::class);
        }

        return parent::__serialize();
    }

    public function __unserialize(array $data): void
    {
        parent::__unserialize($data);

        // Only a loaded collection is serialised, so the copy has its content and needs no loader
        $this->hasFetched = true;
        $this->fetcher = null;
        $this->loadsNewItems = false;
    }

    public function hasChanged(): bool
    {
        // Stored items that haven't been loaded can't have changed, so they aren't loaded just to find that out. New
        // items from a loader given to the constructor are: they count as changed as soon as there are any.
        if (!$this->hasFetched && !$this->loadsNewItems) {
            return false;
        }

        $this->check();

        return parent::hasChanged();
    }

    public function setData(array $data): void
    {
        $this->hasFetched = true;

        parent::setData($data);
    }

    public function setLoader(callable $loader): void
    {
        $this->fetcher = $loader(...);
        $this->loadsNewItems = false;
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

            $this->data = ($this->fetcher)();

            // Like GenericCollection's constructor data, the items of a loader passed to the
            // constructor are new: they all count as additions. The items of a loader set
            // with setLoader() (hydration) are the persisted baseline.
            $this->initialData = $this->loadsNewItems ? [] : $this->data;
            $this->hasFetched = true;
        }
    }
}
