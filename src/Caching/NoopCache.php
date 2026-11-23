<?php

declare(strict_types=1);

namespace Medas\Core\Caching;

use Medas\Core\Interfaces\{Cache, NonPersistentCache};

/**
 * A cache that remembers nothing: `get()` calls the getter every time, `set()` and `remove()` do nothing, and
 * `contains()` is always `false`. `$ttl` is ignored.
 *
 * @class(Medas\ServiceManager\Cache\CacheManager) uses one as the `'default'` cache until the application registers
 * another, so code can always go through a cache without checking whether one was registered:
 *
 * ```php
 * $value = service(CacheManager::class)->get()->get($keyName, fn() => ...);
 * ```
 *
 * @notFor Values that have to be kept, even for the rest of the process; use the `'memory'` cache for those.
 */
class NoopCache implements Cache, NonPersistentCache
{
    public function get(array|string $key, callable $getter, int $ttl = 0): mixed
    {
        return $getter();
    }

    public function set(array|string $key, mixed $value, int $ttl = 0): void
    {
        // Do nothing
    }

    public function remove(array|string $key): void
    {
        // Do nothing
    }

    public function contains(array|string $key): bool
    {
        return false;
    }
}
