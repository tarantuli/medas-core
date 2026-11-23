<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\{Date, Exceptions\InvalidDate};

class DateTest extends BaseTestClass
{
    public function testLeapDay(): void
    {
        self::assertSame(29, new Date(2024, 2, 29)->day);
    }

    public function testNonExistentDay(): void
    {
        $this->expectException(InvalidDate::class);

        new Date(2023, 2, 29);
    }

    public function testNonExistentMonth(): void
    {
        $this->expectException(InvalidDate::class);

        new Date(2024, 13, 1);
    }

    public function testAddingDays(): void
    {
        $date = Date::fromJulianDayNumber(new Date(2024, 12, 30)->toJulianDayNumber() + 3);

        self::assertSame([2025, 1, 2], [$date->year, $date->month, $date->day]);
    }
}
