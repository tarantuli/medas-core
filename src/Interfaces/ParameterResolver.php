<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\ParameterResolverResult;

/**
 * Supplies the value of a method parameter or a property, for the @class(Medas\Core\Interfaces\ObjectInstantiator).
 * Packages register their resolvers with `ServiceConfigBuilder::addParameterResolver()`.
 *
 * Resolvers are asked in order of priority, highest first. The first one that handles the parameter supplies its value,
 * and the rest are skipped. Medas packages themselves use priorities below zero, so an application's resolver with a
 * priority of zero or more comes first.
 *
 * Examples:
 *
 * - @class(Medas\ObjectInstantiator\ArgumentResolving\ServiceFinderByType) injects the service that provides the
 *   parameter's type. In short, this is the core of dependency injection in the medas framework.
 * - @class(Medas\ObjectInstantiator\ArgumentResolving\PreferredDefaultFinder) injects the service named by a
 *   @class(Medas\Core\Attributes\PreferredDefault) attribute.
 * - @class(Medas\ConfigOptions\ConfigOptionResolver) supplies the value of the config option named by a
 *   @class(Medas\Core\Attributes\ConfigValue) attribute.
 * - @class(Medas\HttpRequestHandler\DataResolvers\BodyDataResolver) supplies the value in the body of the request
 *   that matches the parameter name.
 *
 * @assumes The object instantiator creates resolvers itself, with `new` and without arguments, so they can't have
 *          dependencies injected.
 * @state One instance may be used for the whole process, so a resolver mustn't keep anything that differs per request,
 *        like the current request itself.
 * @see CompilableParameterResolver
 * @see ArgumentProcessor
 */
interface ParameterResolver extends DeclaresPriority
{
    public function priority(): int;

    /**
     * Returns a handled result with the value, or an unhandled one when this resolver doesn't supply the parameter, so
     * the next resolver is asked.
     *
     * An exception isn't caught: it ends the resolution, and reaches the caller of the object instantiator.
     */
    public function handle(\ReflectionParameter|\ReflectionProperty $parameter): ParameterResolverResult;
}
