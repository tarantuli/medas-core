<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\ParameterResolverResult;

/**
 * A parameter resolver that splits its work into a static and a dynamic part, so the static part can be cached.
 *
 * `compile()` does all the reflection, once per parameter. `resolveCompiled()` runs on every resolution, with only
 * what `compile()` returned. An object instantiator may still call `handle()` instead, where it can't cache anything,
 * like for closures and properties. Use the @class(Medas\Core\HandlesByCompiling) trait to implement `handle()` with
 * these two methods, so both paths share one implementation.
 *
 * @cache The object `compile()` returns can be cached across requests, until the caches are cleared. A change to what
 *        `compile()` returns therefore needs the caches to be cleared too. In development mode, a change to the file
 *        of the class the parameter belongs to is detected; implement
 *        @class(Medas\Core\Interfaces\DependsOnSourceFiles) for changes in other files.
 * @see CompilableArgumentProcessor
 */
interface CompilableParameterResolver extends ParameterResolver
{
    /**
     * Decides whether this resolver can ever handle the parameter. If it can, it returns an object with everything
     * `resolveCompiled()` needs to know about the parameter, typically the attribute instance. Otherwise it returns
     * `null`, and the resolver is skipped for that parameter from then on.
     *
     * The object ends up in the cache, so it must survive `serialize()` and `unserialize()`, and mustn't contain
     * services. Anything that can differ per request, like request data, environment values or service instances,
     * belongs in `resolveCompiled()`. For a single value, @class(Medas\Core\CompiledValue) will do.
     */
    public function compile(\ReflectionParameter|\ReflectionProperty $parameter): object|null;

    /**
     * Resolves the parameter with the object `compile()` returned, without reflection. It may still return an
     * unhandled result, like for a body value that's missing in this particular request, and then the next resolver is
     * asked, just as with `handle()`.
     */
    public function resolveCompiled(object $compiled): ParameterResolverResult;
}
