# Caching

The caching system is built around two interfaces: `Cache` (a single named cache store) and `CacheManager` (a registry of named caches). Services that need caching inject the `CacheManager` directly through their constructor.

If no cache has been registered under a given name, the `CacheManager` returns a `NoopCache` — a cache that does nothing and always calls the getter. This means all caching code works correctly even when no cache implementation is configured, making caches opt-in without requiring null checks everywhere.

## Using the cache in a service

Inject `CacheManager` into the service constructor and call `get()` to retrieve a named cache. Use the read-through pattern: pass a key and a getter callable, which is called and cached only when no value is found:

```php
use Medas\Core\Attributes\Service;
use Medas\Core\Interfaces\CacheManager;

#[Service]
readonly class UserRepository
{
    public function __construct(
        private CacheManager $cacheManager,
    ) {
    }

    public function find(int $id): User
    {
        return $this->cacheManager->get()->get(
            key: ['users', $id],
            getter: fn() => $this->loadFromDatabase($id),
        );
    }
}
```

To use a named cache other than `'default'`, pass its name to `get()`:

```php
$this->cacheManager->get('filesystem')->get('config', fn() => $this->loadConfig());
```

## Writing and invalidating

Write a value explicitly with `set()`, or remove it with `remove()`:

```php
$this->cacheManager->get()->set(['users', $id], $user);
$this->cacheManager->get()->remove(['users', $id]);
```

## Cache keys

Keys are either a string or an array of strings. Arrays are joined internally to form a namespaced key, which avoids collisions between different parts of the application:

```php
// These are equivalent
$cache->get('users.42', $getter);
$cache->get(['users', '42'], $getter);
```

## TTL

All `Cache` methods accept an optional `$ttl` in seconds. A value of `0` means the entry never expires (for caches that support TTL).

## Named caches

The `CacheManager` maintains multiple named caches. Caches are registered by name, typically during package initialisation:

```php
$cacheManager->register($fileSystemCache, 'filesystem');
$cacheManager->register($memoryCache, 'memory');
```

## Cache marker interfaces

Cache implementations declare their characteristics with marker interfaces:

| Interface | Meaning |
|---|---|
| `NonPersistentCache` | Data does not survive between requests (memory, noop) |
| `MemoryCache` | Data is stored in memory for the duration of the request |
| `FileSystemCache` | Data is persisted to disk |

## Clearing all caches

```php
$this->cacheManager->clearAll();
```

This calls `clear()` on all registered caches that implement `Clearable`. `NoopCache` and other non-persistent caches are unaffected.
