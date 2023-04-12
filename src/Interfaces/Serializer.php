<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Interfaces\Type;

interface Serializer
{
    public function serialize(mixed $value): mixed;

    public function unserialize(mixed $value, Type $type = null): mixed;
}
