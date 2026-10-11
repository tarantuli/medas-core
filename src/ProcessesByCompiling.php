<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Implements ```ArgumentProcessor::process()``` for a @class(Medas\Core\Interfaces\CompilableArgumentProcessor), by
 * compiling the parameter on the spot and processing the argument with the result. This keeps the uncached path and
 * the cached path on one implementation.
 */
trait ProcessesByCompiling
{
    public function process(\ReflectionParameter|\ReflectionProperty $parameter, mixed $argument): mixed
    {
        $compiled = $this->compile($parameter);

        if ($compiled === null) {
            return $argument;
        }

        return $this->processCompiled($compiled, $argument);
    }
}
