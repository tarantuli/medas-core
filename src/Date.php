<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class Date
{
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    )
    {
    }
}
