<?php

declare(strict_types=1);

namespace Medas\Core\Caching;

use Medas\Core\Interfaces\Cache;

/**
 * A cache implementation that does nothing. If ```get()``` is called, it returns the result of the getter. ```set()```
 * and ```remove()``` have no effect.
 *
 * Used as a default cache, which allows other code to pass code through:
 * ```php
 * $value = service(CacheManager::class)->get()->get($keyName, fn() => ...)
 * ````
 * ... without having to check whether a cache was explicitly registered or not.
 */
class NoopCache implements Cache
{
    public function get(array|string $key, callable $getter): mixed
    {
        return $getter();
    }

    public function set(array|string $key, mixed $value): void
    {
        // Do nothing
    }

    public function remove(array|string $key): void
    {
        // Do nothing
    }
}
