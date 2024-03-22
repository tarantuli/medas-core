<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The object instantiator is responsible for instantiating objects, using the given arguments as parameter values.
 *
 * The default implementation is @class(Medas\ObjectInstantiator\ObjectInstantiator). It allows the registration of
 * multiple parameter resolvers and argument processors. It's primary parameter resolver resolves arguments whose type
 * is a class that is marked as a @class(Medas\Core\Attributes\Service), using singleton instances from the
 * @class(Medas\Core\Interfaces\ServiceManager).
 */
interface ObjectInstantiator
{
    /**
     * The return value is an object of type `$type`.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    public function instantiate(string $type, array $givenArguments = []): object;
}
