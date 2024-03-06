<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Caches should maintain data, indexed by a key that's either a string or an array of strings. If no value is found
 * for a given key, the getter closure should be called to determine and store it.
 *
 * Implementations should respect the @class(Medas\Core\Interfaces\NotCacheable) interface.
 *
 * Examples:
 * - @class(Medas\Core\Caching\NoopCache) is a cache that remembers nothing. It always calls the getter to retrieve the
 * value. This should be created as a default cache by CacheManagers if no other cache is registered explicitly.
 *
 * - @class(Medas\Cache\FileSystemCache) is a filesystem cache that stores serialized representations of values
 *   in a directory tree.
 */
interface Cache
{
    /** @param string|string[] $key */
    public function get(string|array $key, callable $getter): mixed;

    /** @param string|string[] $key */
    public function set(string|array $key, mixed $value): void;

    /** @param string|string[] $key */
    public function remove(string|array $key): void;
}
