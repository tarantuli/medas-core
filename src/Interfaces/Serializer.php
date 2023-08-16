<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Serializers should be able to serialize values to a given representation. They must be able to unserialize() those
 * representations back, optionally using a second Type specifying parameter.
 *
 * It depends on the implementations how $foo and $bar = unserialize(serialize($foo)) will compare exactly. They should
 * represent the same data. They must be the same type, and if both are object, they must be the same class.
 *
 * StringSerializer is an extension that requires the return value of serialize() and the first argument of
 * unserialize() to be a string.
 */
interface Serializer
{
    public function serialize(mixed $value): mixed;

    public function unserialize(mixed $value, Type $type = null): mixed;
}
