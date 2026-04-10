# YAML file

Configuration values can be provided through YAML files, read by an implementation of `ConfigManager` such as the one in `medas/config-manager`. The YAML file structure mirrors the dot-separated config paths used by config options: each level of nesting corresponds to a segment of the path.

YAML files are typically placed in a `config/` directory at the root of the application.

## Structure

The YAML key hierarchy maps directly to config option paths. For a `ConfigOption` whose resolved path is `file-manager.max-upload-size`, the YAML entry would be:

```yaml
file-manager:
  max-upload-size: 52428800
```

## Environment variable interpolation

Values in YAML files can reference environment variables using the `$env(VARIABLE_NAME)` syntax. The config manager will replace these placeholders with the corresponding value from the environment or `.env` file at load time.

```yaml
database:
  host: $env(DB_HOST)
  password: $env(DB_PASSWORD)
```

## Requirements

- YAML file names and directory locations are determined by the `ConfigManager` implementation in use.
- Keys must match the group and option names defined in the corresponding `ConfigOption` classes.
- Values must be of a type compatible with what the consuming service expects.
- Environment variable placeholders must use the exact syntax `$env(NAME)`.
