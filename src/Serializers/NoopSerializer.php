<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Interfaces\{Serializer, Type};

/**
 * A serializer that returns values as they are, from both `serialize()` and `unserialize()`. `$type` is ignored.
 *
 * For places that require a `Serializer` where the values don't need converting.
 */
class NoopSerializer implements Serializer
{
    public function serialize(mixed $value): mixed
    {
        return $value;
    }

    public function unserialize(mixed $value, Type|null $type = null): mixed
    {
        return $value;
    }
}
