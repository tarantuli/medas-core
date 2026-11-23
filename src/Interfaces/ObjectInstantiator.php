<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Exceptions\{CircularDependencyFound, CouldNotResolveParameter};

/**
 * Creates objects with their constructor arguments resolved, and resolves the arguments of other methods and
 * functions. Every service the @class(Medas\Core\Interfaces\ServiceManager) creates goes through it.
 *
 * Arguments are resolved by the registered @class(Medas\Core\Interfaces\ParameterResolver) implementations, highest
 * priority first, and then passed through the registered @class(Medas\Core\Interfaces\ArgumentProcessor)
 * implementations. When no resolver handles a parameter, its default value is used, or `null` when it allows that.
 *
 * The default implementation is @class(Medas\ObjectInstantiator\ObjectInstantiator).
 *
 * @assumes The service manager creates the instance itself with `new`, during bootstrap, so its constructor must accept
 *          exactly these arguments, in this order, and nothing is injected:
 *
 *          1. `$parameterResolverNames`: the class names of the registered parameter resolvers, in registration order.
 *          2. `$argumentProcessorNames`: the class names of the registered argument processors, in registration order.
 *          3. `$isDev`: whether the application runs in development mode, so an implementation that caches its
 *             analysis of source code can check whether that code has changed.
 * @see InstantiatesLazily
 */
interface ObjectInstantiator
{
    /**
     * Returns a new instance of `$type` on every call, with its constructor arguments resolved.
     *
     * Values in `$givenArguments`, keyed by parameter name, are used instead of being resolved. They still pass through
     * the argument processors.
     *
     * The return value is an object of type `$type`, which PhpStorm knows from `.phpstorm.meta.php`.
     *
     * @throws CouldNotResolveParameter When a constructor parameter isn't given, no resolver
     *                                                          handles it, and it has no default value and doesn't
     *                                                          allow `null`.
     * @throws CircularDependencyFound When `$type` is already being instantiated further up the
     *                                                         call stack.
     * @notFor Getting a service; `ServiceManager::resolve()` returns the shared instance.
     */
    public function instantiate(string $type, array $givenArguments = []): object;

    /**
     * Returns the arguments for `$method`, in parameter order, ready to be spread into a call.
     *
     * Values in `$givenArguments`, keyed by parameter name, are used instead of being resolved. They still pass through
     * the argument processors.
     *
     * @throws CouldNotResolveParameter When a parameter isn't given, no resolver handles it, and
     *                                                          it has no default value and doesn't allow `null`.
     */
    public function resolveMethodParameters(
        \ReflectionMethod|\ReflectionFunction $method,
        array                                 $givenArguments
    ): array;

    /**
     * Resolves a single parameter or property, through the parameter resolvers only: the argument processors aren't
     * applied.
     *
     * @throws CouldNotResolveParameter When no resolver handles it, and it has no default value
     *                                                          and doesn't allow `null`.
     */
    public function resolveParameter(\ReflectionParameter|\ReflectionProperty $parameter): mixed;
}
