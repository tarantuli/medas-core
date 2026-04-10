# Environment variables

Environment variables are a way to provide configuration values that vary between environments (development, staging, production) without committing them to source control. They are particularly suited for secrets, hostnames, and other deployment-specific values.

In medas, environment variables can be injected in two ways: through YAML file interpolation using `$env(NAME)`, or directly into services using the `#[EnvValue]` attribute.

## Injecting directly into a service

The `#[EnvValue]` attribute injects an environment variable's value directly into a service constructor parameter or promoted property, bypassing the config option and YAML layers entirely. Use this for values that are always environment-driven and would never be configured any other way.

```php
use Medas\Core\Attributes\{EnvValue, Service};

#[Service]
readonly class MailTransport
{
    public function __construct(
        #[EnvValue('MAIL_HOST')]
        private string $host,

        #[EnvValue('MAIL_PORT')]
        private int $port,
    ) {
    }
}
```

## Injecting via YAML interpolation

For values that are configured through the config option system but whose concrete values come from the environment, use `$env(NAME)` syntax inside a YAML file. See [YAML file](yaml-file) for details.

## Requirements

- Environment variable names passed to `#[EnvValue]` must match the name as it appears in the environment or `.env` file exactly.
- Prefer `#[ConfigValue]` with a `ConfigOption` over `#[EnvValue]` for values that could reasonably have a default or be overridden in YAML — use `#[EnvValue]` only for values that are always environment-specific, such as secrets and hostnames.
- Do not read environment variables with `$_ENV` or `getenv()` directly inside services. Always use `#[EnvValue]` or the config system.
