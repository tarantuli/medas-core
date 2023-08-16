<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Interfaces\{Serializer, Type};

/**
 * A Serializer implementation that returns the given value as is for both serialize() and unserialize().
 */
class NoopSerializer implements Serializer
{
    public function serialize(mixed $value): mixed
    {
        return $value;
    }

    public function unserialize(mixed $value, Type $type = null): mixed
    {
        return $value;
    }
}
