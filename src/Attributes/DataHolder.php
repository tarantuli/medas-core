<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks an object as a data holder. It should be convertible between an object and an array.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class DataHolder
{
}
