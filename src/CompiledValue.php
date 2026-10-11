<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A general-purpose compiled object for compilable parameter resolvers and argument processors that only need to
 * remember a single value about a parameter, such as a type name.
 */
readonly class CompiledValue
{
    public function __construct(
        public mixed $value,
    )
    {
    }
}
