<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * The services that implement an interface, for a service that keeps a registry of pluggable handlers, drawers or
 * modifiers that other packages provide.
 *
 * The first `get()` finds the implementing services with @class(Medas\Core\Interfaces\ImplementorFinder), sorts them
 * by priority when asked to, and keeps their class names in the `'default'` cache.
 *
 * @assumes With a sort order, every implementor implements @class(Medas\Core\Interfaces\DeclaresPriority).
 * @cache The class names are kept in the `'default'` cache, under this class's name and the interface. Until the
 *        application registers a cache, they're found again in every process.
 * @state Keeps the services after the first `get()`, for the lifetime of this object.
 */
class CachedImplementorList
{
    private array|null $instances = null;

    /**
     * @param string $interface The interface, or class, whose implementing services to list.
     */
    public function __construct(
        private readonly string               $interface,
        private readonly Lists\SortByPriority $sortByPriority = Lists\SortByPriority::No,
    )
    {
    }

    /**
     * Returns the implementing services, in the requested order.
     *
     * @return object[]
     */
    public function get(): array
    {
        if ($this->instances === null) {
            $classNames = service(Interfaces\CacheManager::class)->get()->get(
                __CLASS__ . ':' . $this->interface,
                fn() => $this->discover()
            );

            $this->instances = namesToServices($classNames);
        }

        return $this->instances;
    }

    /** @return class-string[] */
    private function discover(): array
    {
        $classNames = service(Interfaces\ImplementorFinder::class)->find($this->interface);

        if ($this->sortByPriority === Lists\SortByPriority::No) {
            return $classNames;
        }

        /** @var Interfaces\DeclaresPriority[] $instances */
        $instances = namesToServices($classNames);
        $comparator = match ($this->sortByPriority) {
            Lists\SortByPriority::HighToLow => fn(
                Interfaces\DeclaresPriority $a,
                Interfaces\DeclaresPriority $b,
            ) => -($a->priority() <=> $b->priority()),

            Lists\SortByPriority::LowToHigh => fn(
                Interfaces\DeclaresPriority $a,
                Interfaces\DeclaresPriority $b,
            ) => $a->priority() <=> $b->priority(),

            Lists\SortByPriority::No => null,
        };

        usort($instances, $comparator);

        return servicesToNames($instances);
    }
}
