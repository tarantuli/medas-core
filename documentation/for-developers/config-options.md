# Config options

Config options make configurable values in a package explicit and discoverable. Instead of hardcoding values or reading from a magic string path, a package declares its options as an enum that implements `ConfigOption`. This makes all configurable values listable by tooling and findable by developers.

The value for an option is resolved by joining the group name and option name with a dot, forming a path that is passed to the `ConfigManager`. An option may declare a default value that is used when no configured value is found.

Config values are injected into services using the `#[ConfigValue]` attribute, which takes the fully qualified class name of the `ConfigOption` as its argument.

## Requirements

- Config options must be defined as a `readonly` class implementing `Medas\Core\Interfaces\ConfigOption`.
- The class must implement `group()`, `name()`, `description()`, `hasDefault()`, and `default()`.
- The `description()` must be a single line starting with a capital letter and not ending with a period.
- The resolved config path is `group().name() . '.' . name()` (dot-separated).
- Use `#[ConfigValue(SomeOption::class)]` on a service constructor parameter or promoted property to inject the value.
- Do not read config values with raw string paths — always go through a `ConfigOption`.

## Example

### Defining a config option

```php
use Medas\Core\Interfaces\{ConfigGroup, ConfigOption};

readonly class MaxUploadSize implements ConfigOption
{
    public function group(): ConfigGroup
    {
        return FileManagerGroup::instance();
    }

    public function name(): string
    {
        return 'max-upload-size';
    }

    public function description(): string
    {
        return 'Maximum allowed file upload size in bytes';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): mixed
    {
        return 10 * 1024 * 1024; // 10 MB
    }
}
```

### Injecting a config value into a service

```php
use Medas\Core\Attributes\{ConfigValue, Service};

#[Service]
readonly class FileUploadHandler
{
    public function __construct(
        #[ConfigValue(MaxUploadSize::class)]
        private int $maxUploadSize,
    ) {
    }
}
```
