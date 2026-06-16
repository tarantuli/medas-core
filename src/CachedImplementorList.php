<?php

declare(strict_types=1);

namespace Medas\Core;

class CachedImplementorList
{
    private array|null $instances = null;

    public function __construct(
        private readonly string $interface,
    )
    {
    }

    /** @return object[] */
    public function get(): array
    {
        if ($this->instances === null) {
            $classNames = service(Interfaces\CacheManager::class)->get()->get(
                __CLASS__ . ':' . $this->interface,
                fn() => service(Interfaces\ImplementorFinder::class)->find($this->interface)
            );

            $this->instances = namesToServices($classNames);
        }

        return $this->instances;
    }
}
