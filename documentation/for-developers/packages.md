# Packages

A package is the entry point for a medas module. It declares what a module provides, what it depends on, and how it initialises itself into the application.

Every package extends `BasePackage` and uses the `AsSingleton` trait, making it a singleton that the package manager can reliably retrieve.

## Requirements

- Must extend `BasePackage` and use `AsSingleton`.
- Must implement `dependencies()`, returning instances of all packages this package requires.
- Must implement `sourceDirectory()`, returning `__DIR__` of the package's `src` folder.
- May override `initialize(ServiceConfig $config)` to register services, config groups, and other bindings.
- May override `postInstall()` for any work that must run after all packages have been initialised.
- May override `priority()` to influence the order of initialisation. Higher numbers initialise first. Defaults to `0`.
- May override `isTestPackage()` to return `true` for packages that should only be loaded in test environments.
- Set `hasMarkdownDocumentation()` to `true` if the package ships a `documentation/index.md` file.

## Example

```php
use Medas\Core\{AsSingleton, BasePackage, Interfaces\ServiceConfigBuilder};

class RoutingPackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [
            CorePackage::instance(),
        ];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }

    public function initialize(ServiceConfigBuilder $config): void
    {
        $config->addTypeBinding(RouterImplementation::class, Router::class);
    }

    public function hasMarkdownDocumentation(): bool
    {
        return true;
    }
}
```
