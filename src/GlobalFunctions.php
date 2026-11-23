<?php

declare(strict_types=1);

use Medas\Core\{
    Events\AllowedAccess,
    Events\BasicVote,
    Exceptions\CannotInstantiateClassWithParameters,
    Exceptions\NoServiceManagerRegistered,
    Exceptions\ServiceNotFoundByType,
    FloatingNumber,
    Interfaces\CacheManager,
    Interfaces\ConfigManager,
    Interfaces\EventDispatcher,
    Interfaces\HasId,
    Interfaces\ServiceManager,
    MedasRepository,
    SingletonStore
};

// This file should be in the global namespace
if (!function_exists('medas')) {
    /**
     * Returns the active @class(Medas\Core\MedasRepository), which holds the active service manager and object
     * instantiator.
     *
     * @param bool $initialize Replaces the repository with a new, empty one first.
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
     * Returns the configuration value at `$path`, like `'core.trace-argument-max-length'`, from the
     * @class(Medas\Core\Interfaces\ConfigManager) service.
     */
    function config(string $path): mixed
    {
        return medas()->serviceManager()
            ->resolve(ConfigManager::class)
            ->getValue($path);
    }

    /**
     * Returns the active @class(Medas\Core\Interfaces\ServiceManager).
     *
     * @throws NoServiceManagerRegistered When none has been created yet.
     */
    function sm(): ServiceManager
    {
        return medas()->serviceManager();
    }

    /**
     * Returns the service for `$type`, a class or interface, from the active
     * @class(Medas\Core\Interfaces\ServiceManager). The object is of type `$type`.
     *
     * @throws ServiceNotFoundByType When no service provides `$type`.
     * @throws NoServiceManagerRegistered When no service manager has been created yet.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    function service(string $type): object
    {
        return medas()->serviceManager()
            ->resolve($type);
    }

    /**
     * Returns the class names of the given objects, keeping their keys. The inverse of `namesToServices()`.
     *
     * @return class-string[]
     */
    function servicesToNames(array $services): array
    {
        return array_map(static fn(object $service): string => $service::class, $services);
    }

    /**
     * Returns the service for each class name, keeping their keys, as `service()` returns it.
     *
     * @return object[]
     */
    function namesToServices(array $names): array
    {
        return array_map(static fn(string $name): object => service($name), $names);
    }

    /**
     * Returns the first attribute of type `$type` on `$reflector`, as an object, or `null` when there's none.
     * Subclasses of `$type`, and classes implementing it, count too.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
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
     * Returns the value of a property, even a private or protected one.
     *
     * @throws ReflectionException When the object has no property of that name.
     */
    function propertyValue(object $object, string $propertyName): mixed
    {
        return new ReflectionClass($object)->getProperty($propertyName)->getValue($object);
    }

    // Don't combine the next two functions or try to consolidate the content into one function and call it
    // from the function.
    //
    // The parameter signature should be tight, so users are not seduced to use the wrong method, leading
    // to unclear code (e.g., $parameterTypes = propertyTypes($parameter)).
    /**
     * Returns the types declared for a parameter, as `normalizeType()` returns them.
     *
     * @return array<ReflectionNamedType|ReflectionIntersectionType>
     */
    function parameterTypes(ReflectionParameter $parameter): array
    {
        return normalizeType($parameter->getType());
    }

    /**
     * Returns the types declared for a property, as `normalizeType()` returns them.
     *
     * @return array<ReflectionNamedType|ReflectionIntersectionType>
     */
    function propertyTypes(ReflectionProperty $parameter): array
    {
        return normalizeType($parameter->getType());
    }

    /**
     * Returns the parts of a union type, a single type as the only item, or `[]` when there's no type.
     *
     * An intersection type stays together as one item, also inside a union: `(A&B)|null` gives the intersection
     * `A&B`, and `null`. Code that can only handle named types checks for a `ReflectionIntersectionType`, and throws
     * @class(Medas\Core\Exceptions\IntersectionTypeNotSupported) for one.
     *
     * @return array<ReflectionNamedType|ReflectionIntersectionType>
     */
    function normalizeType(ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType|null $type): array
    {
        if ($type === null) {
            return [];
        }

        return $type instanceof ReflectionUnionType ? $type->getTypes() : [$type];
    }

    /**
     * Calls `$callable` until it returns something falsy, but at most `$maxCount` times. Reaching that limit isn't
     * reported.
     */
    function whileTrue(callable $callable, int $maxCount = 256): void
    {
        $counter = 0;

        while ($callable() && ++$counter < $maxCount) {
            // Do nothing else
        }
    }

    /**
     * Returns `true` when `$value` is so close to zero that it counts as zero: less than `0.0000000001` away from it.
     *
     * @see FloatingNumber
     */
    function is_nihil(float $value): bool
    {
        return FloatingNumber::SMALL_NEGATIVE < $value && $value < FloatingNumber::SMALL_POSITIVE;
    }

    /**
     * Returns `true` when two entities have the same ID, so two objects for the same entity, loaded separately, count
     * as equal.
     *
     * @assumes IDs are unique across all entity classes, like UUIDs or hashes that include the class, so the classes
     *          aren't compared.
     */
    function equalIds(HasId $first, HasId $second): bool
    {
        return (string) $first->id() === (string) $second->id();
    }

    /**
     * Returns the one instance of `$class`, from @class(Medas\Core\SingletonStore). It's for readonly data objects
     * that aren't services and can't use @class(Medas\Core\AsSingleton); for anything else, prefer one of those.
     *
     * @throws CannotInstantiateClassWithParameters When the constructor has required
     *                                                                     parameters.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    function singleton(string $class): object
    {
        return SingletonStore::get($class);
    }

    /**
     * Dispatches `$event` with the @class(Medas\Core\Interfaces\EventDispatcher) service, and returns it.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    function dispatch(object $event): object
    {
        return service(EventDispatcher::class)->dispatch($event);
    }

    /**
     * Dispatches the vote, and throws `$exception` unless the outcome is `AllowedAccess::Allowed`. A callable is only
     * called then, to create the exception.
     *
     * @see BasicVote
     */
    function allowElseThrow(BasicVote $vote, Throwable|callable $exception): void
    {
        dispatch($vote);

        if ($vote->allowedAccess !== AllowedAccess::Allowed) {
            throw ($exception instanceof Throwable ? $exception : $exception());
        }
    }

    /**
     * Returns the value of `$key` from a cache, calling `$getter` and storing its result when the cache doesn't have
     * it. See @class(Medas\Core\Interfaces\Cache).
     *
     * @param string|string[] $key
     * @param string|null     $cache The name of the cache, or `null` for `'default'`.
     */
    function cache(string|array $key, callable $getter, string|null $cache = null, int $ttl = 0): mixed
    {
        return service(CacheManager::class)->get($cache)->get($key, $getter, $ttl);
    }

    /**
     * Stores a value in a cache.
     *
     * @param string|string[] $key
     * @param string|null     $cache The name of the cache, or `null` for `'default'`.
     */
    function cacheSet(string|array $key, mixed $value, string|null $cache = null, int $ttl = 0): void
    {
        service(CacheManager::class)->get($cache)->set($key, $value, $ttl);
    }

    /**
     * Removes the value of `$key` from a cache.
     *
     * @param string|string[] $key
     * @param string|null     $cache The name of the cache, or `null` for `'default'`.
     */
    function cacheUnset(string|array $key, string|null $cache = null): void
    {
        service(CacheManager::class)->get($cache)->remove($key);
    }
}
