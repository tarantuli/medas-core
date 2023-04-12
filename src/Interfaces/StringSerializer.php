<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Interfaces\Serializer;
use Medas\Core\Interfaces\Type;

interface StringSerializer extends Serializer
{
    public function serialize(mixed $value): string;

    /** @param string $value */
    public function unserialize(mixed $value, Type $type = null): mixed;
}
