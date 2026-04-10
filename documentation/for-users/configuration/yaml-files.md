# YAML files

Structured configuration lives in YAML files inside the `config/` directory. The `ConfigManager` reads all YAML files from this directory at startup.

Config values are organised as nested keys that map to dot-separated config paths used internally by packages. For example, a value at `storage.pdo.dsn` in YAML corresponds to the config path `storage.pdo.dsn`.

## Example

```yaml
env: $env(ENV)

storage:
  pdo:
    dsn: $env(DB_PDO_DSN)
    username: $env(DB_PDO_USERNAME)
    password: $env(DB_PDO_PASSWORD)
    persistent-connection: false
  entity-directory: src
  migration-directory: migrations

http-request-handler:
  cors-allowed-origins: "*"
```

## Environment variable interpolation

Any value that looks like `$env(VARIABLE_NAME)` is replaced with the corresponding environment variable at load time. This keeps secrets out of config files while still using the structured YAML format for everything else.

## Notes

- All YAML files in the `config/` directory are loaded — there is no need to register them individually.
- Keys must match the group and option names expected by the packages you use. Refer to each package's documentation for the config paths it reads.
- Unrecognised keys are silently ignored.
