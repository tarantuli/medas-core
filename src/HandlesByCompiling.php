<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Implements `ParameterResolver::handle()` for a @class(Medas\Core\Interfaces\CompilableParameterResolver), by
 * compiling the parameter on the spot and resolving the result. This keeps the uncached path, like resolving a
 * property or a closure parameter, and the cached path on one implementation.
 *
 * @performance `compile()` runs on every call to `handle()`, so its reflection isn't saved on that path.
 */
trait HandlesByCompiling
{
    public function handle(\ReflectionParameter|\ReflectionProperty $parameter): ParameterResolverResult
    {
        $compiled = $this->compile($parameter);

        if ($compiled === null) {
            return new ParameterResolverResult(false);
        }

        return $this->resolveCompiled($compiled);
    }
}
