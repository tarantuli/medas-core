<?php

declare(strict_types=1);

namespace Medas\CoreTest\MockUps;

readonly class RequiredParameters
{
    public function __construct(
        public int $value,
    )
    {
    }
}
