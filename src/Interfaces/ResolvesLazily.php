<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Exceptions\{MultipleImplementorsFound, ServiceNotFoundByType};

/**
 * A @class(Medas\Core\Interfaces\ServiceManager) that can return services as lazy objects, so dependencies can be
 * injected without instantiating them, and their own dependencies, up front.
 *
 * This is a separate interface, so service managers that don't implement it keep working: dependencies are then
 * resolved with `resolve()`.
 *
 * @see InstantiatesLazily
 */
interface ResolvesLazily
{
    /**
     * Returns the service for `$type`. When it hasn't been instantiated yet, it may return a lazy object instead, which
     * is instantiated on first use. Either way, the returned object is registered as the service, so later calls to
     * `resolve()` return the same instance.
     *
     * The return value is an object of type `$type`, which PhpStorm knows from `.phpstorm.meta.php`.
     *
     * @throws ServiceNotFoundByType When no service provides `$type`.
     * @throws MultipleImplementorsFound When several services provide `$type`, and no type
     *                                                          binding decides between them.
     */
    public function resolveLazy(string $type): object;
}
