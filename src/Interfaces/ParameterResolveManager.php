<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A parameter resolve manager is responsible for resolving parameter values using registered
 * @class(Medas\Core\Interfaces\ParameterResolver) and
 * @class(Medas\Core\Interfaces\ArgumentProcessor) instances.
 */
interface ParameterResolveManager
{
    public function resolveMethodParameters(
        \ReflectionMethod|\ReflectionFunction $method,
        array                                 $givenArguments
    ): array;

    public function resolveParameter(\ReflectionParameter|\ReflectionProperty $parameter): mixed;
}
