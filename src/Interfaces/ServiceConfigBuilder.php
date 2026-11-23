<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Collects the service configuration while it's built: the packages and their services, type bindings, manual
 * bindings, parameter resolvers, argument processors and exception handlers.
 *
 * The application configures it in the initialiser it gives the service manager, and every package adds to it in
 * `Package::initialize()`.
 *
 * The default implementation is @class(Medas\ServiceManager\ServiceConfigBuilder).
 *
 * @assumes It's only used while the configuration is built. The result can be cached, and then neither the initialiser
 *          nor `Package::initialize()` runs, so everything added here must be the same in every process.
 * @notFor Setup that needs live services, or has to happen in every process; that belongs in `Package::ready()`.
 * @see Package
 */
interface ServiceConfigBuilder
{
    /**
     * Whether the application runs in development mode, for packages that bind development-only behaviour while they
     * initialise.
     */
    public bool $isDev { get; }

    /**
     * Adds the package, after the packages it depends on, and discovers their services. Adding a package that's
     * already there has no effect.
     *
     * @param bool $doInitialize Calls the package's `initialize()` right away. Packages added in the initialiser don't
     *                           need it, because the service manager initialises all of them once it returns.
     */
    public function addPackage(Package $package, bool $doInitialize = false): self;

    /**
     * Like `addPackage()` for each package, without initialising them right away.
     *
     * @param Package[] $packages
     */
    public function addPackages(array $packages): self;

    /**
     * Like `addPackage()`, but only when `$isDev` is set.
     */
    public function addDevPackage(Package $package, bool $doInitialize = false): self;

    /**
     * Like `addPackages()`, but only when `$isDev` is set.
     *
     * @param Package[] $packages
     */
    public function addDevPackages(array $packages): self;

    /**
     * Makes every type in `$forTypes` resolve to `$implementationClass`. A binding wins over discovered services, so
     * this is how to choose between several implementations of a type. `$implementationClass` is also listed among
     * the implementors of those types.
     */
    public function addTypeBinding(string $implementationClass, string ...$forTypes): self;

    /**
     * Binds a value to one parameter of a method, which is then supplied when the class is instantiated or the method
     * is called. Use it for parameters that can't be resolved otherwise, like scalars.
     *
     * @param string $class The class that declares the method. For a constructor inherited from a parent class, that's
     *                      the parent class.
     * @param mixed  $value Ends up in the cached configuration, so it must survive `serialize()` and `unserialize()`.
     */
    public function addManualBinding(
        string $class,
        string $parameter,
        mixed  $value,
        string $method = '__construct'
    ): self;

    /**
     * @param string $parameterResolver The class of a `ParameterResolver`. Resolvers are ordered by their priority, not
     *                                  by the order in which they're added.
     */
    public function addParameterResolver(string $parameterResolver): self;

    public function addParameterResolvers(string ...$parameterResolver): self;

    /**
     * @param string $argumentProcessor The class of an `ArgumentProcessor`. Processors are ordered by their priority,
     *                                  not by the order in which they're added.
     */
    public function addArgumentProcessor(string $argumentProcessor): self;

    public function addArgumentProcessors(string ...$argumentProcessor): self;

    /**
     * @param string $exceptionHandler The class of an `ExceptionHandler`.
     */
    public function addExceptionHandler(string $exceptionHandler): self;

    public function addExceptionHandlers(string ...$exceptionHandlers): self;
}
