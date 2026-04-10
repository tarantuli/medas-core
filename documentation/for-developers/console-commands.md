# Console commands

Console commands are services that are discovered and executed from the command line. Each command belongs to a group, which provides the namespace for the command's full invocation path.

## Structure

A command implements `ConsoleCommand` (or extends `BaseConsoleCommand`) and a group implements `ConsoleCommandGroup` (or extends `BaseConsoleCommandGroup`). Both are `#[Service]`-annotated `readonly` classes.

The full invocation path is formed as `group:name`, e.g. `cache:clear-all`. Groups can be nested, forming paths like `medas:cache:clear-all`.

## `ConsoleCommand` interface

| Method | Description |
|---|---|
| `group()` | Returns the `ConsoleCommandGroup` this command belongs to |
| `name()` | The command's name within its group (kebab-case) |
| `fullCommand()` | The full invocation path — provided by `BaseConsoleCommand` |
| `aliases()` | Short alias words (e.g. `c.entity`) that bypass the group path |
| `description()` | A single line starting with a capital, not ending with a period |
| `options()` | Declares accepted `Option` objects; unknown options throw an exception |
| `allowedArgumentCount()` | A `Range` of how many positional arguments are accepted |
| `process(CommandInput $input)` | Executes the command |

`BaseConsoleCommand` provides default implementations for `fullCommand()`, `aliases()` (empty), `options()` (none), and `allowedArgumentCount()` (zero arguments).

## Options

Options are declared by returning `Option` objects from `options()`:

```php
// A flag with no value (e.g. --force)
new Option(longCode: 'force', shortCode: 'f')

// An option that may carry a value (e.g. --format=json or --format)
Option::valueAllowed(longCode: 'format')

// An option that requires a value (e.g. --output=file.txt)
Option::valueRequired(longCode: 'output', shortCode: 'o')
```

## Argument count

`allowedArgumentCount()` returns a `Range`:

```php
new Range(0)        // exactly 0 arguments
new Range(1)        // exactly 1 argument
new Range(1, 3)     // between 1 and 3 arguments
new Range(1, false) // at least 1 argument, no upper limit
```

## Reading input

`CommandInput` provides access to positional arguments (one-based) and named options:

```php
$input->hasArgument(1);         // bool
$input->getArgument(1);         // mixed, null if not set
$input->hasOption('format');    // bool
$input->getOption('format');    // mixed, true if passed without a value
```

## Example

```php
use Medas\Console\Commands\{BaseConsoleCommand, CommandInput, Option, Range};
use Medas\Core\Attributes\Service;

#[Service]
readonly class ClearCacheCommand extends BaseConsoleCommand
{
    public function __construct(
        private CacheGroup $group,
        private CacheManager $cacheManager,
    ) {
    }

    public function group(): CacheGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'clear-all';
    }

    public function description(): string
    {
        return 'Clears all registered caches';
    }

    public function process(CommandInput $input): void
    {
        $this->cacheManager->clearAll();
    }
}
```

## Defining a group

```php
use Medas\Console\Commands\BaseConsoleCommandGroup;
use Medas\Core\Attributes\Service;

#[Service]
readonly class CacheGroup extends BaseConsoleCommandGroup
{
    public function parent(): null
    {
        return null;
    }

    public function name(): string
    {
        return 'cache';
    }
}
```

This produces a full command path of `cache:clear-all`.
