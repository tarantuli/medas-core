# Environment variables

Environment variables hold values that differ between environments (development, staging, production) and values that must not be committed to source control, such as database passwords and API keys.

## The `.env` file

Copy `.env.example` to `.env` and fill in the values for your environment:

```bash
cp .env.example .env
```

`.env` is listed in `.gitignore` and must never be committed. `.env.example` is committed and serves as the reference for which variables are required.

## Common variables

The variables required depend on which packages are installed. The following are typical for a full application:

| Variable | Description |
|---|---|
| `ENV` | Environment name, e.g. `dev` or `prod` |
| `DB_PDO_DSN` | PDO connection string, e.g. `mysql:dbname=myapp;host=127.0.0.1` |
| `DB_PDO_USERNAME` | Database username |
| `DB_PDO_PASSWORD` | Database password |
| `EMAIL_HOST` | SMTP host |
| `EMAIL_PORT` | SMTP port |
| `EMAIL_USERNAME` | SMTP username |
| `EMAIL_PASSWORD` | SMTP password |

Refer to `.env.example` for the full list of variables required by your application.

## How variables are read

The `ConfigManager` reads `.env` from the project root during bootstrapping via `readEnv(__DIR__)`. Variables are then available inside YAML values using the `$env(NAME)` syntax, and can also be injected directly into services using `#[EnvValue]`.
