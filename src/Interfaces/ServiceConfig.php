<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The default implementation is @class(Medas\ServiceManager\ServiceConfig).
 */
interface ServiceConfig
{
    public function addExceptionHandler(ExceptionHandler $exceptionHandler): self;

    /** @var ExceptionHandler[] $exceptionHandlers */
    public function addExceptionHandlers(...$exceptionHandlers): self;

    public function exceptionHandlers(): array;

    public function addParameterResolver(ParameterResolver $parameterResolver): self;

    public function parameterResolvers(): array;

    public function addArgumentProcessor(ArgumentProcessor $argumentProcessor): self;

    public function argumentProcessors(): array;
}
