<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/** See @class(Medas\Core\Interfaces\Serializer) */
interface StringSerializer extends Serializer
{
    public function serialize(mixed $value): string;

    /** @param string $value */
    public function unserialize(mixed $value, Type|null $type = null): mixed;
}
