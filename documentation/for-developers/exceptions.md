# Exceptions

All package exceptions extend `BaseException`, which formats its message automatically using a `vsprintf`-style pattern and `StringMaker`. This keeps exception messages consistent, human-readable, and free from manual string concatenation.

Each distinct error condition gets its own exception class. Exception classes should never be reused across different error conditions.

## Design rationale

Declaring a dedicated constructor for each exception class enforces that the information needed to describe the error is **typed and named**. Compare:

```php
// ❌ Stringly typed — the caller decides what to include, and nothing enforces correctness
throw new \RuntimeException('File not found: ' . $path);

// ✅ Typed and named — the exception class defines exactly what it needs
throw new FileNotFound($path);
```

This has several benefits:

- **Findability** — call sites are easy to locate by searching for `new FileNotFound(`, rather than hunting for ad-hoc message strings.
- **Consistency** — the message format is defined once in `pattern()`, not scattered across every throw site.
- **Type safety** — the constructor signature enforces what context the caller must provide. Missing or wrong-typed context is a compile-time error, not a runtime surprise.
- **Catchability** — each error condition can be caught independently with a specific `catch (FileNotFound)` clause, without parsing message strings.

## Defining an exception

Extend `BaseException` and implement `pattern()`. Pass the format arguments to `parent::__construct()` in the order they appear in the pattern:

```php
class FileNotFound extends BaseException
{
    public function __construct(string $path)
    {
        parent::__construct($path);
    }

    public function pattern(): string
    {
        return 'file not found: %s';
    }
}
```

The pattern uses `vsprintf` placeholders (`%s`, `%d`, etc.). Arguments are converted to readable strings automatically by `StringMaker`, so objects, arrays, and other types can be passed directly.

## Wrapping a previous exception

Override `previous()` to attach a cause:

```php
class DatabaseQueryFailed extends BaseException
{
    public function __construct(
        string $query,
        private readonly \Throwable $cause,
    ) {
        parent::__construct($query);
    }

    public function pattern(): string
    {
        return 'database query failed: %s';
    }

    public function previous(): \Throwable|null
    {
        return $this->cause;
    }
}
```

## Providing suggestions

Implement the `Suggestions` interface when the exception might leave a developer unsure what to do next. Suggestions may hint at the cause, list configuration steps, or recommend packages to install:

```php
class NoServiceManagerRegistered extends BaseException implements Suggestions
{
    public function pattern(): string
    {
        return 'no service manager has been registered yet';
    }

    public function suggestions(): array
    {
        return [
            'Create a ServiceManager implementation and register it with MedasRepository::setServiceManager()',
        ];
    }
}
```

## Requirements

- All exceptions must extend `BaseException`.
- One class per error condition — never reuse an exception class for different errors.
- `pattern()` must return a `vsprintf`-compatible format string.
- Arguments must be passed to `parent::__construct()` in the same order as their placeholders in the pattern.
- Use `Suggestions` when a developer encountering the exception might not know how to resolve it.
