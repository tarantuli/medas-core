<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class ParameterResolverResult
{
    public function __construct(
        public bool  $handled,
        public mixed $result = null,
    )
    {
    }
}
