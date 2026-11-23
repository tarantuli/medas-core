<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A calendar date without a time, in the proleptic Gregorian calendar.
 *
 * Only existing dates can be created, from 1 January of the year 1 to 31 December 32767, the range of PHP's
 * `checkdate()`.
 */
#[Attributes\DataHolder]
readonly class Date
{
    /**
     * Returns today's date, in PHP's default time zone.
     */
    public static function today(): self
    {
        $now = new \DateTimeImmutable();

        return new self(
            (int) $now->format('Y'),
            (int) $now->format('m'),
            (int) $now->format('d'),
        );
    }

    /**
     * Returns the date of a Julian Day Number, the inverse of `toJulianDayNumber()`. Together, the two make day
     * arithmetic simple: adding `$n` days is `Date::fromJulianDayNumber($date->toJulianDayNumber() + $n)`.
     *
     * @throws Exceptions\InvalidDate When the date falls outside the years 1 to 32767.
     */
    public static function fromJulianDayNumber(int $julianDayNumber): self
    {
        // JDN-to-Gregorian (Richards), per en.wikipedia.org/wiki/Julian_day
        $a = $julianDayNumber + 32044;
        $b = intdiv(4 * $a + 3, 146097);
        $c = $a - intdiv(146097 * $b, 4);
        $d = intdiv(4 * $c + 3, 1461);
        $e = $c - intdiv(1461 * $d, 4);
        $m = intdiv(5 * $e + 2, 153);

        return new self(
            100 * $b + $d - 4800 + intdiv($m, 10),
            $m + 3 - 12 * intdiv($m, 10),
            $e - intdiv(153 * $m + 2, 5) + 1,
        );
    }

    /**
     * @throws Exceptions\InvalidDate When the date doesn't exist, like 30 February.
     */
    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    )
    {
        if (!checkdate($month, $day, $year)) {
            throw new Exceptions\InvalidDate($year, $month, $day);
        }
    }

    /**
     * Returns the Julian Day Number of this date: a running count of days, so consecutive dates differ by exactly one,
     * and an earlier date has a smaller number. Adding days and counting the days between dates become plain integer
     * arithmetic.
     */
    public function toJulianDayNumber(): int
    {
        // Gregorian-to-JDN, per en.wikipedia.org/wiki/Julian_day. The divisions truncate toward zero, as the
        // algorithm requires, which is what intdiv() does.
        $a = intdiv($this->month - 14, 12);

        return intdiv(1461 * ($this->year + 4800 + $a), 4)
            + intdiv(367 * ($this->month - 2 - 12 * $a), 12)
            - intdiv(3 * intdiv($this->year + 4900 + $a, 100), 4)
            + $this->day
            - 32075;
    }
}
