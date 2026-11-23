<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A general-purpose compiled object for compilable parameter resolvers and argument processors that only need to
 * remember a single value about a parameter, such as a type name.
 *
 * @assumes `$value` survives `serialize()` and `unserialize()`, because the compiled object ends up in the cache.
 * @see Interfaces\CompilableParameterResolver
 * @see Interfaces\CompilableArgumentProcessor
 */
readonly class CompiledValue
{
    public function __construct(
        public mixed $value,
    )
    {
    }
}
