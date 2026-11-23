<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * What a @class(Medas\Core\Interfaces\ParameterResolver) returns: whether it supplies the parameter, and if so, the
 * value.
 *
 * With `$handled` set to `false`, the next resolver is asked and `$result` is ignored. With `true`, `$result` is used
 * as the value, also when it's `null`, and no other resolver is asked.
 */
readonly class ParameterResolverResult
{
    public function __construct(
        public bool  $handled,
        public mixed $result = null,
    )
    {
    }
}
