<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\DataHolder]
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

    // The date for a Julian Day Number - the inverse of toJulianDayNumber(), so a
    // shifted number round-trips back to a calendar date. Together the two turn
    // "add N days" into fromJulianDayNumber(toJulianDayNumber() + N).
    //
    // JDN-to-Gregorian (Richards), per en.wikipedia.org/wiki/Julian_day
    public static function fromJulianDayNumber(int $julianDayNumber): self
    {
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

    public function __construct(
        public int $year,
        public int $month,
        public int $day,
    )
    {
    }

    // The Julian Day Number for this (proleptic Gregorian) date: a running day count
    // where consecutive dates differ by exactly one. That makes day arithmetic and
    // day-differences plain integer operations, and it preserves order - an earlier
    // date has a smaller number. The divisions truncate toward zero as the algorithm
    // requires, which is what intdiv() does.
    //
    // Gregorian-to-JDN, per en.wikipedia.org/wiki/Julian_day
    public function toJulianDayNumber(): int
    {
        $a = intdiv($this->month - 14, 12);

        return intdiv(1461 * ($this->year + 4800 + $a), 4)
            + intdiv(367 * ($this->month - 2 - 12 * $a), 12)
            - intdiv(3 * intdiv($this->year + 4900 + $a, 100), 4)
            + $this->day
            - 32075;
    }
}
