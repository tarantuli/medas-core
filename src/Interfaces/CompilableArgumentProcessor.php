<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An argument processor that splits its work into a static and a dynamic part, so the static part can be cached.
 *
 * ```compile()``` runs once per parameter, and its result is cached across requests. It returns a serializable object
 * with everything the processor needs to know about the parameter, or null when the processor never changes
 * arguments for this parameter, so it is skipped entirely for that parameter from then on.
 *
 * ```processCompiled()``` runs on every argument, with only that object - no reflection.
 *
 * Use the @class(Medas\Core\ProcessesByCompiling) trait to implement ```process()``` in terms of these two methods, so
 * both code paths share one implementation.
 */
interface CompilableArgumentProcessor extends ArgumentProcessor
{
    public function compile(\ReflectionParameter|\ReflectionProperty $parameter): object|null;

    public function processCompiled(object $compiled, mixed $argument): mixed;
}
