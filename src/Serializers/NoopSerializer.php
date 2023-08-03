<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Interfaces\{Serializer, Type};

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
