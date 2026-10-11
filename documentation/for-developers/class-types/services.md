# Services

A service is a singleton class that's responsible for a single, well-defined task. Services are the primary building block of the medas framework. They are discovered and wired together automatically by the service manager based on the `#[Service]` attribute.

## Requirements

- Must be annotated with `#[Service]`.
- Must be `readonly`.
- Must be state-independent — a service must produce the same output for the same input regardless of when or how many times it is called.
- Should have only one primary public method. If a class needs many public methods to fulfil its responsibility, it is probably doing too much and should be split up.
- Constructor parameters are injected automatically by the service manager. Injected values may be other services, config values (`#[ConfigValue]`), or environment values (`#[EnvValue]`).

## Example

```php
use Medas\Core\Attributes\{ConfigValue, Service};

#[Service]
readonly class ThumbnailResizer
{
    public function __construct(
        #[ConfigValue(MaxThumbnailWidth::class)]
        private int $maxWidth,
    ) {
    }

    public function resize(Image $image): Image
    {
        // ...
    }
}
```

## Lazy injection

Services that are injected as dependencies are lazy objects by default: the injected object has the real class, but its
constructor (and with it the resolution of its own dependencies) only runs on first access to one of its properties. A
service that is injected but not used in a request is never constructed. This also means:

- An exception thrown by a constructor surfaces where the service is first used, not where it is injected.
- Side effects of a constructor are postponed until the service is used. A service whose constructor must run when it
  is injected must be marked `#[Service(lazy: false)]` — better still, keep constructors free of side effects.
- Services that depend on each other (A needs B, B needs A) work, as long as neither constructor uses the other.

Services without constructor parameters, and classes extending internal PHP classes, are always instantiated directly.
Services resolved directly with `service()` are instantiated directly as well, since they are used right away.

## What services are not

- Services are not data objects. If a class primarily holds data rather than performs an action, it should be a [data object](data-objects.md) instead.
- Services must not cache state between calls. Use a `CacheManager` if caching is needed.
- Services must not be instantiated manually with `new`. Always resolve them through the service manager.
