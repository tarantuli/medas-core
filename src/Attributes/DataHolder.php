<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks a value object, like `Date`, `Period` or `File`, whose properties hold its data and nothing else, so it can be
 * converted to an array and back without losing anything.
 *
 * A property that holds such an object is marked with @class(Medas\Core\Types\DataHolder) for storage, which stores
 * it as an array, or as JSON in backends that only store strings.
 *
 * @assumes Every property can be converted to an array value and back, so it holds no services, resources or
 *          closures.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class DataHolder
{
}
