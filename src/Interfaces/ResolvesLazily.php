<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A @class(Medas\Core\Interfaces\ServiceManager) that can resolve services as lazy objects, for injecting them as
 * dependencies without instantiating them (and their dependencies) up front.
 *
 * This is a separate interface, so service managers that don't implement it keep working: dependencies are then
 * resolved with ```resolve()```.
 */
interface ResolvesLazily
{
    /**
     * Returns the service for the given type. If it hasn't been instantiated yet, it may return a lazy object that
     * is instantiated on first use. The returned object is registered as the service, so later calls to
     * ```resolve()``` return the same instance.
     *
     * The return value is an object of type `$type`.
     */
    public function resolveLazy(string $type): object;
}
