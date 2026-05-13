<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The default implementation is @class(Medas\ServiceManager\ServiceConfig).
 */
interface ServiceConfig
{
    public function isDev(): bool;

    public function addPackage(Package $package, bool $doInitialize = false): self;

    public function addPackages(array $packages): self;

    public function addDevPackage(Package $package, bool $doInitialize = false): self;

    public function addDevPackages(array $packages): self;

    public function addExceptionHandler(ExceptionHandler $exceptionHandler): self;

    /** @var ExceptionHandler[] $exceptionHandlers */
    public function addExceptionHandlers(...$exceptionHandlers): self;

    public function exceptionHandlers(): array;

    /**
     * Registers exception handler class names to be lazily resolved via service() when first needed.
     * Class names are serializable and therefore cacheable, unlike instances.
     */
    public function addExceptionHandlerClasses(string ...$classes): self;

    /** @return string[] */
    public function exceptionHandlerClasses(): array;

    /**
     * Registers a type binding in the service mapping without requiring an instance.
     * Equivalent to ServiceManager::bindImplementation() but usable during initialize().
     */
    public function addTypeBinding(string $implementationClass, string ...$forTypes): self;

    public function addManualBinding(
        string $class,
        string $parameter,
        mixed  $value,
        string $method = '__construct',
    ): void;

    public function addParameterResolver(ParameterResolver $parameterResolver): self;

    public function parameterResolvers(): array;

    public function addArgumentProcessor(ArgumentProcessor $argumentProcessor): self;

    public function argumentProcessors(): array;
}
