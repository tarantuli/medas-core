<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Compares floating-point numbers with a margin, so rounding errors don't count: numbers that differ by less than
 * `0.0000000001` count as equal, as `is_nihil()` decides.
 */
class FloatingNumber
{
    /** A very small positive float that's used to compare numbers to zero */
    public const float SMALL_POSITIVE = +1e-10;

    /** A very small negative float that's used to compare numbers to zero */
    public const float SMALL_NEGATIVE = -1e-10;

    /**
     * Returns `true` when `$a` is more than `$b`, or equal to it.
     */
    public static function isMoreThanOrEqual(float $a, float $b): bool
    {
        return $a > $b || is_nihil($a - $b);
    }

    /**
     * Returns `true` when `$a` is less than `$b`, or equal to it.
     */
    public static function isLessThanOrEqual(float $a, float $b): bool
    {
        return $a < $b || is_nihil($a - $b);
    }

    /**
     * Returns `true` when `$a` and `$b` are equal.
     */
    public static function areEqual(float $a, float $b): bool
    {
        return is_nihil($a - $b);
    }

    /**
     * Returns `true` when `$a` is less than zero, or equal to it.
     */
    public static function isZeroOrLess(float $a): bool
    {
        return $a < 0 || is_nihil($a);
    }

    /**
     * Returns `true` when `$a` is more than zero, or equal to it.
     */
    public static function isZeroOrMore(float $a): bool
    {
        return $a > 0 || is_nihil($a);
    }

    /**
     * Returns `true` when `$value` is between `$left` and `$right`, or equal to either. Their order doesn't matter.
     */
    public static function isBetweenInclusive(float $left, float $value, float $right): bool
    {
        return self::isMoreThanOrEqual($value, min($left, $right))
            && self::isLessThanOrEqual($value, max($left, $right));
    }

    /**
     * Returns `true` when `$a` is more than zero, and not equal to it.
     */
    public static function isMoreThanZero(float $a): bool
    {
        return !is_nihil($a) && $a > 0;
    }
}
