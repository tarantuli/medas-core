<?php

declare(strict_types=1);

// This file should be in the global namespace

use Medas\Core\Interfaces\{ConfigManager, ServiceManager};
use Medas\Core\MedasRepository;

function medas(bool $initialize = false): MedasRepository
{
    static $repository;

    if ($initialize || !isset($repository)) {
        $repository = new MedasRepository();
    }

    return $repository;
}

function config(string $path): mixed
{
    return medas()->serviceManager()
        ->resolve(ConfigManager::class)
        ->getValue($path);
}

function sm(): ServiceManager
{
    return medas()->serviceManager();
}

/**
 * The return value is an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
 */
function service(string $type): object
{
    return medas()->serviceManager()
        ->resolve($type);
}

/**
 * The return value is null or an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
 */
function attribute(
    string                                                                                                    $type,
    ReflectionClassConstant|ReflectionClass|ReflectionFunctionAbstract|ReflectionParameter|ReflectionProperty $reflector
): object|null
{
    if (!$attributes = $reflector->getAttributes($type, ReflectionAttribute::IS_INSTANCEOF)) {
        return null;
    }

    return $attributes[0]->newInstance();
}

function propertyValue(object $object, string $propertyName): mixed
{
    return (new ReflectionClass($object))->getProperty($propertyName)->getValue($object);
}

/**
 * This method returns the types declared on the given ReflectionParameter (or ReflectionProperty) as a normalized array
 * of ReflectionNamedType instances.
 *
 * @return ReflectionNamedType[]
 */
function parameterTypes(ReflectionParameter|ReflectionProperty $parameter): array
{
    $type = $parameter->getType();

    if (!$type) {
        return [];
    }

    return $type instanceof ReflectionUnionType
        ? $type->getTypes()
        : [$type];
}

/**
 * This method returns the types declared on the given ReflectionProperty (or ReflectionParameter) as a normalized
 * array of ReflectionNamedType instances.
 *
 * @return ReflectionNamedType[]
 */
function propertyTypes(ReflectionParameter|ReflectionProperty $parameter): array
{
    return parameterTypes($parameter);
}
