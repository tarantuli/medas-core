<?php

declare(strict_types=1);

namespace Medas\CoreTest\MockUps;

readonly class OptionalParameters
{
    public function __construct(
        public int $value = 1,
    )
    {
    }
}
