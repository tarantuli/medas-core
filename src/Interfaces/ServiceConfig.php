<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\ServiceManager\ErrorHandling\ExceptionHandler;

/**
 * The default implementation is @class(Medas\ServiceManager\ServiceConfig).
 */
interface ServiceConfig
{
    public function addExceptionHandler(ExceptionHandler $exceptionHandler): self;

    public function addParameterResolver(ParameterResolver $parameterResolver): self;

    public function addArgumentProcessor(ArgumentProcessor $argumentProcessor): self;
}
