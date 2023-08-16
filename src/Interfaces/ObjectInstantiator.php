<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The object instantiator is responsible for instantiating objects, using the given arguments as parameter values.
 *
 * The default implementation is found in medas/object-instantiator. It allows the registration of multiple
 * parameter resolvers and argument processors. It's primary parameter resolver resolves arguments whose type is a
 * class that is marked as a Service, using singleton instances from the ServiceeManager.
 */
interface ObjectInstantiator
{
    /**
     * The return value  is an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
     */
    public function instantiate(string $type, array $givenArguments = []): object;
}
