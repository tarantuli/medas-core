<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class InvalidDate extends BaseException
{
    public function __construct(int $year, int $month, int $day)
    {
        parent::__construct($year, $month, $day);
    }

    public function pattern(): string
    {
        return 'invalid date: year %s, month %s, day %s';
    }
}
