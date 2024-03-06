<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Cache managers should maintain a list of named caches. If get('default') is called and no cache with that name has
 * been registered yet, it should create a NoopCache instance, register that and return it.
 *
 * clearAll() must call clear() on all registered caches implementing Clearable.
 *
 * Example:
 *
 * - The straight forward implementation at @class(Medas\ServiceManager\Cache\CacheManager).
 */
interface CacheManager
{
    public function get(string $name = 'default'): Cache;

    /** @return Cache[] */
    public function getAll(): array;

    public function register(Cache $cache, string $name = 'default'): void;

    public function clearAll(): void;
}
