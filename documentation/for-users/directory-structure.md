# Directory structure

A typical medas application is organised as follows:

```
project/
├── bin/
│   ├── console              # CLI entrypoint
│   ├── post-install         # Runs after composer install/update
│   └── post-install-scripts/
│       └── clear-cache-dirs.sh
├── config/
│   └── general.yaml         # Application configuration
├── migrations/              # Database migrations
├── public/
│   ├── .htaccess            # Rewrites all requests to index.php
│   └── index.php            # HTTP entrypoint
├── src/
│   ├── AppPackage.php       # Root package, declares all dependencies
│   └── ...                  # Application services, entities, commands
├── tests/
├── var/
│   ├── cache/               # Filesystem cache (written at runtime)
│   └── dirs-to-clear/       # Cache directories to wipe on post-install
├── vendor/
├── bootstrap.php            # Sets up the service manager and core services
├── composer.json
├── .env                     # Local environment variables (not committed)
└── .env.example             # Template for .env
```

## Key files

| File | Purpose |
|---|---|
| `bootstrap.php` | Creates the `ServiceManager`, loads config, registers storage and exception handlers |
| `public/index.php` | HTTP entrypoint — requires `bootstrap.php` and hands off to `HttpRequestHandler` |
| `bin/console` | CLI entrypoint — requires `bootstrap.php` and hands off to `CommandProcessor` |
| `bin/post-install` | Runs after `composer install` and `composer update` via Composer scripts |
| `config/general.yaml` | Application-level configuration values |
| `.env` | Environment-specific secrets and variables, never committed to source control |
| `.env.example` | Committed template listing all required environment variables with placeholder values |
