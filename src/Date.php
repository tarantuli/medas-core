<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class Date
{
    public static function today(): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            (int) $now->format('Y'),
            (int) $now->format('m'),
            (int) $now->format('d'),
        );
    }

    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    )
    {
    }
}
