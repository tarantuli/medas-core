<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\{Interfaces\Serializer, Interfaces\Type, Types\Relation};

/**
 * A Serializer implementation that defers to PHP's internal serialize() and unserialize() methods.
 */
class PhpSerializer implements Serializer
{
    public function serialize(mixed $value): string
    {
        return serialize($value);
    }

    public function unserialize(mixed $value, Type|null $type = null): mixed
    {
        $allowedClasses = $type instanceof Relation ? [$type->entity] : false;

        return unserialize($value, ['allowed_classes' => $allowedClasses]);
    }
}
