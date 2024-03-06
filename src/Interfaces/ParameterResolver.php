<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\ParameterResolverResult;

/**
 * Parameter resolvers are called to resolve the value of a method parameter.
 *
 * They are called in order of highest to lowest priority. If handle() returns true, the resulting value is fetched
 * using result() and further resolvers are skipped. Medas packages themselves have priorities lower than zero.
 *
 * Examples:
 *
 * - @class(Medas\ObjectInstantiator\ParameterResolving\ServiceFinderByType) is a resolver that looks for services
 *   implementing the type of the parameter. In short, this is the core of dependency injection in the medas framework.
 *
 * - @class(Medas\ObjectInstantiator\ParameterResolving\PreferredDefaultFinder) is a resolver that looks for values
 *   tagged with a preferred default.
 *
 * - @class(Medas\ConfigOptions\ConfigOptionResolver) is a resolver that looks for values tagged as config options.
 *
 * - @class(Medas\HttpRequestHandler\BodyDataResolver) is a resolver that looks for values in the body input of the
 *   request that match the parameter name.
 */
interface ParameterResolver
{
    public function priority(): int;

    public function handle(\ReflectionParameter|\ReflectionProperty $parameter): ParameterResolverResult;
}
