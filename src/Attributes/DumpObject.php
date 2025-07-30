<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Objects marked with this attribute are dumb objects, data holders that may be cast freely between arrays and objects.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class DumpObject
{
}
