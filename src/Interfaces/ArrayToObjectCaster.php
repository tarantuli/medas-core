<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Creates an object from an associative array of property values, converting nested arrays into the objects the
 * properties are typed with. It's the reverse of @class(Medas\Core\Interfaces\ObjectToArrayCaster).
 *
 * The default implementation is @class(Medas\ObjectToArraySerializer\ArrayToObjectCaster).
 */
interface ArrayToObjectCaster
{
    /**
     * Returns an object of type `$className`, with its properties set from `$values`.
     */
    public function cast(array $values, string $className);
}
