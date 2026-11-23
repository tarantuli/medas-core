<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Converts values to another representation, and back with `unserialize()`.
 *
 * After `$copy = unserialize(serialize($value))`, `$copy` represents the same data as `$value`, has the same type, and
 * for an object the same class. How exactly the two compare depends on the implementation.
 *
 * Examples:
 *
 * - @class(Medas\Core\Serializers\PhpSerializer) uses PHP's own `serialize()` and `unserialize()`.
 * - @class(Medas\ObjectToArraySerializer\ObjectToArraySerializer) converts objects to arrays.
 *
 * @see StringSerializer For serialisers that produce strings.
 */
interface Serializer
{
    public function serialize(mixed $value): mixed;

    /**
     * @param Type|null $type What to convert the value back into, for representations that don't say
     */
    public function unserialize(mixed $value, Type|null $type = null): mixed;
}
