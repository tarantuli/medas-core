<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The default implementation is @class(Medas\ServiceManager\ServiceConfig).
 */
interface ServiceConfigBuilder
{
    public function addPackage(Package $package, bool $doInitialize = false): self;

    /** @var Package[] $packages */
    public function addPackages(array $packages): self;

    public function addDevPackage(Package $package, bool $doInitialize = false): self;

    /** @var Package[] $packages */
    public function addDevPackages(array $packages): self;

    public function addTypeBinding(string $implementationClass, string ...$forTypes): self;

    public function addManualBinding(
        string $class,
        string $parameter,
        mixed  $value,
        string $method = '__construct'
    ): void;

    public function addParameterResolver(string $parameterResolver): self;

    public function addArgumentProcessor(string $argumentProcessor): self;

    public function addExceptionHandler(string $exceptionHandler): self;

    /** @var string[] $exceptionHandlers */
    public function addExceptionHandlers(array $exceptionHandlers): self;
}
