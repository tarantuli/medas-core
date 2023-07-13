<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ParameterResolveManager
{
    public function resolveMethodParameters(\ReflectionMethod|\ReflectionFunction $method, array $givenArguments): array;

    public function resolveParameter(\ReflectionParameter|\ReflectionProperty $parameter): mixed;
}
