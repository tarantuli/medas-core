<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A date without a time, held in a @class(Medas\Core\Date). @class(Medas\StorageManager\Shared\ValueSerializer)
 * stores it as `'YYYY-MM-DD'`.
 *
 * Used for properties typed as `Date` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Date extends BaseType
{
}
