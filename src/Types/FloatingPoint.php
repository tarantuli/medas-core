<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A floating-point number.
 *
 * Used for properties typed as `float` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class FloatingPoint extends BaseType
{
}
