<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A date and time, held in a `\DateTime`. @class(Medas\StorageManager\Shared\ValueSerializer) stores it as
 * `'YYYY-MM-DD HH:MM:SS'`, in PHP's default time zone.
 *
 * Used for properties typed as `\DateTime` that have no type attribute.
 *
 * Unexpectedly, no package reads `$minValue`, `$maxValue` or `$timeZone` yet: values aren't checked against the range,
 * and the time zone doesn't affect how they're stored.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DateTime extends BaseType
{
    public function __construct(
        public \DateTimeInterface|null $minValue = null,
        public \DateTimeInterface|null $maxValue = null,
        public \DateTimeZone|null      $timeZone = null,
    )
    {
    }
}
