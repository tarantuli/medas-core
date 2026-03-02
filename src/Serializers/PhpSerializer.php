<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\{Interfaces\Serializer, Interfaces\Type};

/**
 * A Serializer implementation that defers to PHP's internal serialize() and unserialize() methods.
 */
class PhpSerializer implements Serializer
{
    public function serialize(mixed $value): string
    {
        try {
            return serialize($value);
        }
        catch (\Throwable $e) {
            throw new \Exception(
                get_debug_type($value) . ': ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    public function unserialize(mixed $value, Type|null $type = null): mixed
    {
        // Allow any class to be unserialized
        return unserialize($value);
    }
}
