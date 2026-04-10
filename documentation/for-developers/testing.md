# Testing

Tests live in the `tests/` directory at the package root and are run with PHPUnit. Each package bootstraps itself by loading the autoloader and the core global functions.

## Bootstrap

The `phpunit.bootstrap.php` file at the package root sets up the test environment:

```php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/GlobalFunctions.php';
```

Packages that depend on a service manager or other infrastructure should initialise and configure a `MedasRepository` in a shared base test case or a `setUp()` method.

## Test packages

A package can be marked as test-only by overriding `isTestPackage()` on its `Package` class:

```php
class MyPackageTestSupportPackage extends BasePackage
{
    use AsSingleton;

    public function isTestPackage(): bool
    {
        return true;
    }

    // ...
}
```

Test packages are excluded from production builds. Use them to register mock services, in-memory caches, or test fixtures that should never be loaded in a real environment.

## Mocking services

Because services are resolved through the `ServiceManager`, swap in a test double by re-binding the interface before the test runs:

```php
$config->bind(MailerInterface::class, NullMailer::class);
```

For services with no interface, bind the concrete class to a subclass or a `PHPUnit` mock registered via a factory.

## The `#[RequiredButUnused]` attribute

When implementing an interface or overriding an abstract method, some parameters may be required by the signature but not used by a particular implementation. Mark them with `#[RequiredButUnused]` to silence static analysis warnings and communicate intent clearly:

```php
public function serialize(
    mixed $value,
    #[RequiredButUnused] Type|null $type = null,
): string {
    return json_encode($value);
}
```

## Conventions

- Test class names mirror the class under test with a `Test` suffix, e.g. `IdentifierTest` for `Identifier`.
- Test method names describe the scenario: `testToCamelCaseFromSnakeCase()`.
- Each test method should assert one behaviour. Avoid large omnibus test methods.
- Do not use global state between tests. Reset `MedasRepository` with `medas(initialize: true)` in `tearDown()` if a test modifies it.
