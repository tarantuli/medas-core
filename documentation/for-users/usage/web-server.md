# Web server

The web server must be configured to serve the `public/` directory as the document root. All requests that don't match a physical file are rewritten to `public/index.php`.

## Apache

A `.htaccess` file in `public/` handles all rewrites automatically when `mod_rewrite` is enabled. No additional Apache configuration is required beyond pointing the virtual host at the `public/` directory:

```apache
<VirtualHost *:80>
    DocumentRoot /path/to/project/public
    <Directory /path/to/project/public>
        AllowOverride All
    </Directory>
</VirtualHost>
```

`AllowOverride All` is required for the `.htaccess` rewrite rules to take effect.

The `.htaccess` does three things:

- Passes the `Authorization` header through to PHP (required for bearer token authentication).
- Redirects requests directly to `index.php` to the clean URL equivalent.
- Rewrites all other requests that don't match a physical file to `index.php`.

## What `index.php` does

After bootstrapping, the HTTP entrypoint delegates to the `HttpRequestHandler`:

```php
require_once __DIR__ . '/../bootstrap.php';

service(HttpRequestHandler::class)->handle();
service(EntityManager::class)->flush();
```

`HttpRequestHandler::handle()` routes the request, runs the matched handler, and produces a response. `EntityManager::flush()` writes any pending entity changes to the database after the handler completes.

Any application-level setup that must run on every request (such as resetting periodic state) can be added before the `handle()` call.
