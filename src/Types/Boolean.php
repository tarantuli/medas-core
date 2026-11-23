<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * `true` or `false`. @class(Medas\StorageManager\Shared\ValueSerializer) stores it as `'1'` or `'0'`.
 *
 * Used for properties typed as `bool` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Boolean extends BaseType
{
}
