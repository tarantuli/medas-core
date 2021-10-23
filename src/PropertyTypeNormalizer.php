<?php

declare(strict_types=1);

namespace Medas\Core;

class PropertyTypeNormalizer
{
    public static function allowsType(\ReflectionProperty $property, string $type): bool
    {
        return ($type === 'null' && $property->getType()->allowsNull())
            || in_array($type, self::getNames($property));
    }

    public static function getNames(\ReflectionProperty $property): array
    {
        return array_map(fn($value): string => $value->getName(), self::getNamedTypes($property));
    }

    /**
     * @return \ReflectionNamedType[]
     */
    public static function getNamedTypes(\ReflectionProperty $property): array
    {
        $type = $property->getType();

        if (null === $type) {
            return [];
        }

        return $type instanceof \ReflectionUnionType ? $type->getTypes() : [$type];
    }
}
