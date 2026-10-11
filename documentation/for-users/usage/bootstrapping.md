# Bootstrapping

`bootstrap.php` at the project root is the shared entry point for all application entry points (HTTP, CLI, post-install). It sets up the service manager, loads configuration, registers storage, and configures exception handlers.

Both `public/index.php` and `bin/console` start with `require_once __DIR__ . '/../bootstrap.php'`.

## What bootstrapping does

**1. Create the cache**

```php
$isDev = getenv('MEDAS_ENV') === 'dev';

// APCu is usually disabled on the command line (apc.enable_cli), so console commands and post-install scripts fall
// back to the file system cache
$cache = ApcuCache::isAvailable()
    ? new ApcuCache('my-app')
    : new FileSystemCache(__DIR__ . '/var/cache');
```

This becomes the default cache. It stores the compiled service configuration between requests, avoiding the cost of re-scanning and re-wiring services on every request, as well as other compiled data such as the object instantiator's resolution plans and entity metadata. A plain `FileSystemCache` works everywhere; APCu is faster for web requests.

**2. Create the service manager**

```php
$sm = new ServiceManager(function () use ($isDev): ServiceConfigBuilder {
    $builder = new ServiceConfigBuilder(ObjectInstantiator::class, isDev: $isDev);

    $builder->addPackage(AppPackage::instance());

    return $builder;
}, $cache);
```

`addPackage()` registers the root application package. The service manager resolves all declared dependencies transitively, so only the root package needs to be registered here. The closure is only called when the service configuration isn't cached yet. With `isDev`, dev packages are registered, warnings are turned into exceptions, and cached analysis of source code (such as the object instantiator's plans) is checked for changes.

**3. Load configuration**

```php
service(ConfigManager::class)
    ->addDirectory('config')
    ->readEnv(__DIR__);
```

`addDirectory('config')` loads all YAML files from the `config/` directory. `readEnv(__DIR__)` reads the `.env` file from the project root.

**4. Register storage**

```php
service(StorageManager::class)
    ->add(medas()->objectInstantiator()->instantiate(Database::class));
```

Registers the database connection with the storage manager, making it available to the entity manager and other storage-aware services.

**5. Register exception handlers**

```php
$sm->config()->addExceptionHandlers(
    service(CliExceptionPrinter::class),
    service(ExceptionDispatcher::class),
    service(ExceptionLogger::class),
    service(ExceptionMailer::class),
);
```

Exception handlers are called in order when an unhandled exception reaches the top of the call stack. Register only the handlers appropriate for your environment.
