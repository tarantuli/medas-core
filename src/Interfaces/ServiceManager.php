<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Exceptions\{MultipleImplementorsFound, ServiceNotFoundByType};

/**
 * The dependency injection container: it knows which class provides each type, and keeps one instance of each service
 * for the rest of the process. The global functions `sm()` and `service()` reach it through `medas()`.
 *
 * A type is provided by a service when the service is that class, extends it or implements it, or when the type is
 * bound to the service by hand. When several services provide a type, it only resolves when a binding decides between
 * them.
 *
 * The default implementation is @class(Medas\ServiceManager\ServiceManager).
 *
 * @state Keeps every service it instantiates, so all callers share one instance of each.
 * @see ResolvesLazily
 * @see ObjectInstantiator
 */
interface ServiceManager
{
    /**
     * Returns the service for `$type`, and instantiates it the first time. Every later call for the same type returns
     * the same instance.
     *
     * The return value is an object of type `$type`, which PhpStorm knows from `.phpstorm.meta.php`.
     *
     * @throws ServiceNotFoundByType When no service provides `$type`.
     * @throws MultipleImplementorsFound When several services provide `$type`, and no type
     *                                                          binding decides between them.
     */
    public function resolve(string $type): object;

    /**
     * Returns the class that `$type` resolves to, without instantiating it, or `null` when no service provides it.
     *
     * @throws MultipleImplementorsFound When several services provide `$type`, and no type
     *                                                          binding decides between them.
     */
    public function findImplementingClass(string $type): string|null;
}
