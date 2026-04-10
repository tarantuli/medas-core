# Post-install

Post-install runs automatically after every `composer install` and `composer update` via Composer's script hooks. It can also be run manually at any time.

## What it does

Post-install performs two things in order:

**1. Clears cache directories**

The shell script `bin/post-install-scripts/clear-cache-dirs.sh` wipes all directories listed in `var/dirs-to-clear/`. Each file in that directory contains the path to a cache directory that should be emptied on install, such as `var/cache`. This ensures stale compiled service graphs and other cached data are removed before the new code is used.

**2. Runs package post-install hooks**

The PHP script `bin/post-install` bootstraps the application and calls `ServiceManager::postInstall()`:

```php
require_once __DIR__ . '/../bootstrap.php';

ServiceManager::postInstall();
```

`ServiceManager::postInstall()` does two things:

- Clears all registered caches (via `CacheManager::clearAll()`), which rebuilds the compiled service graph on the next request.
- Calls `postInstall()` on every registered package, allowing packages to perform one-time setup such as running database migrations or seeding default data.

## Running manually

```bash
php bin/post-install
```

Or via Composer:

```bash
composer run post-install-cmd
```

## Registering a cache directory to clear

Add a file to `var/dirs-to-clear/` containing the absolute or project-relative path to the directory:

```
var/cache/my-package
```

The clear script will empty that directory on every post-install run, but leave the directory itself in place.

## Adding a package post-install hook

Override `postInstall()` in your package class:

```php
class MyPackage extends BasePackage
{
    use AsSingleton;

    public function postInstall(): void
    {
        service(MigrationRunner::class)->runPending();
    }
}
```

`postInstall()` is called once per package after all packages have been initialised, so services are fully available.
