<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Keeps values under a key, so expensive results can be reused. Get one from the
 * @class(Medas\Core\Interfaces\CacheManager), or through the global function `cache()`, instead of creating one.
 *
 * A key is a string or an array of strings; the same array always refers to the same entry. A `$ttl` is in seconds,
 * and `0` means the entry never expires.
 *
 * Examples:
 *
 * - @class(Medas\Core\Caching\NoopCache) remembers nothing, and always calls the getter. Cache managers return it as
 *   `'default'` until the application registers a real cache.
 * - @class(Medas\Cache\FileSystemCache) stores serialised values in a directory tree.
 *
 * @assumes Stored values survive `serialize()` and `unserialize()`, and contain no services. Whether a value comes
 *          back as the same object or as a copy depends on the implementation, so don't change a value after storing
 *          it.
 * @see NotCacheable
 */
interface Cache
{
    /**
     * Returns the value stored under `$key`. When there's none, or it has expired, calls `$getter`, stores what it
     * returns, also when that's `null`, and returns it.
     *
     * A value that implements @class(Medas\Core\Interfaces\NotCacheable) is returned, but not stored.
     *
     * @param string|string[] $key
     */
    public function get(string|array $key, callable $getter, int $ttl = 0): mixed;

    /**
     * Stores `$value` under `$key`, replacing what was there. A value that implements
     * @class(Medas\Core\Interfaces\NotCacheable) isn't stored, and mustn't leave an older value under the same key.
     *
     * @param string|string[] $key
     */
    public function set(string|array $key, mixed $value, int $ttl = 0): void;

    /** @param string|string[] $key */
    public function remove(string|array $key): void;

    /**
     * Whether a value that hasn't expired is stored under `$key`.
     *
     * @param string|string[] $key
     */
    public function contains(string|array $key): bool;
}
