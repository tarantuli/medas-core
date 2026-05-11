# Installation

## Requirements

- PHP 8.4 or higher
- Composer
- The PHP extensions required by the packages you use (e.g. `ext-apcu`, `ext-pdo`, `ext-fileinfo`)

## Composer packages

All medas packages are published under the `morphp/` vendor namespace. Three packages are required by every application:

| Package                            | Description                                                                            |
|------------------------------------|----------------------------------------------------------------------------------------|
| `morphp/medas-core`                | Interfaces, base classes, attributes, and utilities used by all other packages         |
| `morphp/medas-service-manager`     | Discovers and wires services, manages the service graph and caches it between requests |
| `morphp/medas-object-instantiator` | Resolves constructor parameters and instantiates services                              |

Add them to your `composer.json`:

```json
{
  "require": {
    "morphp/medas-core": "^3",
    "morphp/medas-service-manager": "^3",
    "morphp/medas-object-instantiator": "^3"
  }
}
```

Most applications will also need several of these commonly used packages:

| Package                           | Description                                                               |
|-----------------------------------|---------------------------------------------------------------------------|
| `morphp/medas-config-manager`     | Reads YAML config files and `.env` files, resolves `$env()` placeholders  |
| `morphp/medas-events`             | PSR-14 event dispatcher with attribute-based listener discovery           |
| `morphp/medas-cache`              | Filesystem and memory cache implementations                               |
| `morphp/medas-console`            | Console command infrastructure (`ConsoleCommand`, `CommandInput`, groups) |
| `morphp/medas-console-printer`    | Renders and runs console commands from the CLI                            |
| `morphp/medas-routing`            | HTTP routing                                                              |
| `morphp/medas-entity-manager`     | ORM-style entity persistence                                              |
| `morphp/medas-pdo-mysql`          | MySQL PDO storage backend                                                 |
| `morphp/medas-ramsey-uuid-bridge` | UUID generation via `ramsey/uuid`                                         |

All packages require PHP 8.4 or higher and declare their own dependencies, so Composer pulls in transitive packages
automatically.

## Steps

**1. Install dependencies**

```bash
composer install
```

This also runs the post-install scripts automatically via Composer's `post-install-cmd` hook.
See [Post-install](usage/post-install.md) for details.

**2. Create your environment file**

Copy the example file and fill in the values for your environment:

```bash
cp .env.example .env
```

Edit `.env` with the correct values for your database, mail server, and any other environment-specific settings.
See [Environment variables](configuration/environment-variables.md) for a description of each variable.

**3. Point your web server at `public/`**

The document root must be set to the `public/` directory. All requests are rewritten to `public/index.php` via
`.htaccess`. See [Web server](usage/web-server.md) for details.
