<?php

declare(strict_types=1);

use Medas\Core\{Interfaces\ConfigManager, Interfaces\ServiceManager, MedasRepository};

// This file should be in the global namespace
/**
 * This global function holds the reference to the active MedasRepository, which holds the active ServiceManager and
 * ObjectInstantiator. Set $initialize to true to reset the repository to a new instance.
 */
function medas(bool $initialize = false): MedasRepository
{
    static $repository;

    if ($initialize || !isset($repository)) {
        $repository = new MedasRepository();
    }

    return $repository;
}

/**
 * This global function calls the ConfigManager service and requests the config value for the given value.
 */
function config(string $path): mixed
{
    return medas()->serviceManager()
        ->resolve(ConfigManager::class)
        ->getValue($path);
}

/**
 * This global functions returns the active ServiceManager instance.
 */
function sm(): ServiceManager
{
    return medas()->serviceManager();
}

/**
 * This global function calls the active ServiceManager instance and asks it to resolve $type to its service instance.
 *
 * The return value is an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
 */
function service(string $type): object
{
    return medas()->serviceManager()
        ->resolve($type);
}

/**
 * This global function asks the given Reflector if it has an attribute that's of the given type. If so, it returns
 * an instance of the attribute class.
 *
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

/**
 * This global function returns the value of the given property of the given object using reflection.
 */
function propertyValue(object $object, string $propertyName): mixed
{
    return (new ReflectionClass($object))->getProperty($propertyName)->getValue($object);
}

/*
 * Don't combine the next two functions or try to consolidate the content into one function, and call it
 * from the function.
 *
 * The parameter signature should be tight, so users are not seduced to use the wrong method, leading
 * to unclear code (e.g. $parameterTypes = propertyTypes($parameter)).
 */
/**
 * This method returns the types declared on the given ReflectionParameter as a normalized array
 * of ReflectionNamedType instances.
 *
 * @return ReflectionNamedType[]
 */
function parameterTypes(ReflectionParameter $parameter): array
{
    return normalizeType($parameter->getType());
}

/**
 * This method returns the types declared on the given ReflectionProperty as a normalized
 * array of ReflectionNamedType instances.
 *
 * @return ReflectionNamedType[]
 */
function propertyTypes(ReflectionProperty $parameter): array
{
    return normalizeType($parameter->getType());
}

function normalizeType(ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType|null $type): array
{
    if ($type === null) {
        return [];
    }

    return ($type instanceof ReflectionUnionType || $type instanceof ReflectionIntersectionType)
        ? $type->getTypes()
        : [$type];
}

function whileTrue(callable $callable, int $maxCount = 256): void
{
    $counter = 0;

    while ($callable() && ++$counter < $maxCount) {
        // Do nothing else
    }
}
