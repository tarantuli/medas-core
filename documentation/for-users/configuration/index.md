# Configuration

Application configuration is split across two layers:

- **YAML files** in `config/` — for structured, non-secret values
- **Environment variables** in `.env` — for environment-specific and secret values

YAML values can reference environment variables using `$env(NAME)` syntax, keeping secrets out of config files entirely.

See the sub-pages for details on each layer:

- [YAML files](yaml-files)
- [Environment variables](environment-variables)
