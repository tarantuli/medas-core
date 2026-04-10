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

## What services are not

- Services are not data objects. If a class primarily holds data rather than performs an action, it should be a [data object](data-objects) instead.
- Services must not cache state between calls. Use a `CacheManager` if caching is needed.
- Services must not be instantiated manually with `new`. Always resolve them through the service manager.
