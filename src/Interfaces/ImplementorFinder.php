<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Lists all services that provide a type, so a package can use every implementation other packages offer, like
 * handlers or plugins. @class(Medas\Core\CachedImplementorList) builds on it.
 *
 * The default implementation is @class(Medas\ServiceManager\Mapping\ImplementorFinder).
 *
 * @notFor Resolving one service; use `ServiceManager::resolve()`, which throws when a type has more than one
 *         implementation.
 */
interface ImplementorFinder
{
    /**
     * Each class must itself be resolvable as a service by its own name, because callers like
     * `CachedImplementorList` pass it to `service()`.
     *
     * @return class-string[] Each class once, in no guaranteed order, so callers that care about order should sort the
     *                        result themselves.
     */
    public function find(string $interface): array;
}
