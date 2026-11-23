<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Registry of named caches. Packages fetch a cache by name instead of creating their own, so the application decides
 * where cached data is stored.
 *
 * Two names work without being registered:
 *
 * - `'default'`, the cache the global function `cache()` uses. Until the application registers one, it's a cache that
 *   remembers nothing, like @class(Medas\Core\Caching\NoopCache), so code can always go through a cache.
 * - `'memory'`, a @class(Medas\Core\Interfaces\MemoryCache) for the rest of the process, as long as a class
 *   implements that interface. The cache package provides one.
 *
 * The default implementation is @class(Medas\ServiceManager\Cache\CacheManager).
 *
 * @state Keeps the registered caches for the lifetime of the process.
 */
interface CacheManager
{
    /**
     * @param string|null $name `null` means `'default'`, which is what the global function `cache()` passes when no
     *                          cache is named.
     */
    public function get(string|null $name = null): Cache;

    /** @return Cache[] Keyed by name */
    public function getAll(): array;

    /**
     * Registers `$cache` under `$name`, replacing a cache that was registered under it before.
     */
    public function register(Cache $cache, string $name = 'default'): void;

    /**
     * Calls `clear()` on every registered cache that implements @class(Medas\Core\Interfaces\Clearable).
     */
    public function clearAll(): void;
}
