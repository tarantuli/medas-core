<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\ObjectToArraySerializer\ObjectToArrayCaster;

/**
 * Leaves the conversion of a class to an array and back to a handler, instead of converting it property by property.
 *
 * `$className` is the class of a service that implements @class(Medas\Core\Interfaces\ObjectToArrayHandler): its
 * `toArray()` is used when an object of the class is cast to an array, and `toObject()` when it's cast back. The array
 * is stored under a key with the handler's class name, so the object can be restored even where the type isn't
 * known.
 *
 * @see Handler
 * @see ObjectToArrayCaster
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class ObjectToArrayHandler
{
    public function __construct(
        public string $className,
    )
    {
    }
}
