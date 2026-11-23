<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An argument processor that splits its work into a static and a dynamic part, so the static part can be cached.
 *
 * `compile()` does all the reflection, once per parameter. `processCompiled()` runs on every argument, with only what
 * `compile()` returned. An object instantiator may still call `process()` instead, where it can't cache anything,
 * like for closures. Use the @class(Medas\Core\ProcessesByCompiling) trait to implement `process()` with these two
 * methods, so both paths share one implementation.
 *
 * @cache The object `compile()` returns can be cached across requests, until the caches are cleared. A change to what
 *        `compile()` returns therefore needs the caches to be cleared too. In development mode, a change to the file
 *        of the class the parameter belongs to is detected; implement
 *        @class(Medas\Core\Interfaces\DependsOnSourceFiles) for changes in other files.
 * @see CompilableParameterResolver
 */
interface CompilableArgumentProcessor extends ArgumentProcessor
{
    /**
     * Returns an object with everything `processCompiled()` needs to know about the parameter, or `null` when this
     * processor never changes arguments for it, so it's skipped for that parameter from then on.
     *
     * The object ends up in the cache, so it must survive `serialize()` and `unserialize()`, and mustn't contain
     * services. For a single value, @class(Medas\Core\CompiledValue) will do.
     */
    public function compile(\ReflectionParameter|\ReflectionProperty $parameter): object|null;

    /**
     * Returns the processed argument, using the object `compile()` returned, without reflection.
     */
    public function processCompiled(object $compiled, mixed $argument): mixed;
}
