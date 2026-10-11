<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\ParameterResolverResult;

/**
 * A parameter resolver that splits its work into a static and a dynamic part, so the static part can be cached.
 *
 * ```compile()``` runs once per parameter, and its result is cached across requests. It does all the reflection: it
 * decides whether this resolver can ever handle the parameter and, if so, returns a serializable object with
 * everything the resolver needs to know about the parameter (typically the attribute instance). It returns null when
 * the resolver never applies to the parameter, so it is skipped entirely for that parameter from then on.
 *
 * ```resolveCompiled()``` runs on every resolution, with only that object - no reflection. It may still return an
 * unhandled result (e.g. a body value that is missing in this particular request), in which case the next resolver
 * is tried, exactly as with ```handle()```.
 *
 * The compiled object must be serializable and must not contain services, since it ends up in the cache. Anything
 * that can differ per request (request data, env values, service instances) belongs in ```resolveCompiled()```.
 *
 * Use the @class(Medas\Core\HandlesByCompiling) trait to implement ```handle()``` in terms of these two methods, so
 * both code paths share one implementation.
 */
interface CompilableParameterResolver extends ParameterResolver
{
    public function compile(\ReflectionParameter|\ReflectionProperty $parameter): object|null;

    public function resolveCompiled(object $compiled): ParameterResolverResult;
}
