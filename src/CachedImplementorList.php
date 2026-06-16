<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Use this when a service needs to discover and cache all implementors of an interface — for example, a registry of
 * pluggable handlers, drawers, or modifiers that other packages register via #[Service].
 *
 * On the first call to get(), it will discover all implementors of the given interface, cache them by class name, and
 * sort them by priority if requested.
 */
class CachedImplementorList
{
    private array|null $instances = null;

    public function __construct(
        private readonly string               $interface,
        private readonly Lists\SortByPriority $sortByPriority = Lists\SortByPriority::No,
    )
    {
    }

    /** @return object[] */
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
