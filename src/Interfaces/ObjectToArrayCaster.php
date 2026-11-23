<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Converts an object to an associative array of its property values, converting the objects in it too, so the result
 * can be stored or sent as JSON. @class(Medas\Core\Interfaces\ArrayToObjectCaster) converts it back.
 *
 * A class can take over its own conversion with @class(Medas\Core\Attributes\ObjectToArrayHandler), and a property
 * with @class(Medas\Core\Attributes\Handler).
 *
 * The default implementation is @class(Medas\ObjectToArraySerializer\ObjectToArrayCaster).
 */
interface ObjectToArrayCaster
{
    public function cast(object $value): array;
}
