<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A @class(Medas\Core\Interfaces\Serializer) whose representation is always a string.
 */
interface StringSerializer extends Serializer
{
    public function serialize(mixed $value): string;

    /** @param string $value */
    public function unserialize(mixed $value, Type|null $type = null): mixed;
}
