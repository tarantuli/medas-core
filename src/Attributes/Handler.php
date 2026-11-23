<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\ObjectToArraySerializer\ObjectToArrayCaster;

/**
 * Converts the value of a property with a @class(Medas\Core\Interfaces\PropertyHandler) when its object is cast to an
 * array and back, instead of the default conversion based on the property's type.
 *
 * `$className` is the class of a `PropertyHandler` service: its `serialize()` is used when the object is cast to an
 * array, and `unserialize()` when it's cast back.
 *
 * @see ObjectToArrayHandler
 * @see ObjectToArrayCaster
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
readonly class Handler
{
    public function __construct(
        public string $className,
    )
    {
    }
}
