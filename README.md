# medas-core

The core package of the [Medas](https://github.com/tarantuli/medas-core) framework. **Medas** stands for *MorPHP
Explicitly Defined Annotation System*.

This package provides the foundational building blocks used across all Medas packages: base interfaces, attributes,
utility classes, string handling, collections, events, and the global function layer.

> **Note:** This framework is a personal project built to organise the author's own code and to practise specific
> patterns and practices. It is not recommended for general use — most components only implement what has been needed
> so far.

---

## Requirements

- PHP 8.4+
- `ext-mbstring`
- `ext-curl`

---

## Installation

```bash
composer require morphp/medas-core
```

---

## Concepts

### Design philosophy

Medas is built around a small set of explicit principles:

**No magic.** Names and labels must always be given explicitly — never derived from class names or context. Options are
typed and enumerable, not buried in compound strings or arrays.

**Explicit over implicit.** Configuration is done through typed attributes and explicit method calls, not convention.

**Low regex usage.** Regular expressions are only used when necessary or when they are vastly more efficient than
parsing the string manually.

**Package independence.** Packages depend on each other through interfaces, not concrete classes.

### Class types

All classes in the framework aim to be one of three things:

- **Singleton services** — do one thing, have one public method, are `readonly`, and hold no state
- **Singleton data objects** — hold shared data, do nothing by themselves
- **Dumb data objects** — typed containers; methods only add, remove, return, or filter data

---

## Core components

### Global functions (`GlobalFunctions.php`)

The global function layer is the primary entry point for interacting with the framework at runtime. It must be loaded
explicitly:

```php
CorePackage::instance()->loadGlobalFunctions();
```

Key functions:

```php
// Access the active MedasRepository
medas(): MedasRepository

// Resolve a service from the service manager
service(string $type): object

// Shorthand for the service manager
sm(): ServiceManager

// Read a config value
config(string $path): mixed

// Dispatch an event
dispatch(object $event): object

// Dispatch a vote and throw if access is denied
allowElseThrow(BasicVote $vote, Throwable|callable $exception): void

// Cache helpers
cache(string|array $key, callable $getter, ?string $cache = null): mixed
cacheSet(string|array $key, mixed $value, ?string $cache = null): void
cacheUnset(string|array $key, ?string $cache = null): void

// Get a singleton instance of a readonly data object
singleton(string $class): object

// Reflection helpers
attribute(string $type, ReflectionClass|...$reflector): ?object
parameterTypes(ReflectionParameter $parameter): ReflectionNamedType[]
propertyTypes(ReflectionProperty $property): ReflectionNamedType[]
propertyValue(object $object, string $propertyName): mixed

// Float comparison
is_nihil(float $value): bool

// Loop with a safety counter
whileTrue(callable $callable, int $maxCount = 256): void
```

---

### Attributes

Attributes are the primary way to annotate classes and their members.

| Attribute                               | Target               | Purpose                                                             |
|-----------------------------------------|----------------------|---------------------------------------------------------------------|
| `#[Service]`                            | Class                | Marks a class as a singleton service                                |
| `#[EventListener]`                      | Method               | Marks a method as an event listener                                 |
| `#[EnvValue(name: '...')]`              | Parameter / Property | Injects a value from `$_ENV`                                        |
| `#[ConfigValue(configOption: '...')]`   | Parameter / Property | Injects a config value                                              |
| `#[PreferredDefault(className: '...')]` | Parameter / Property | Specifies a preferred service implementation                        |
| `#[Handler(className: '...')]`          | Property             | Delegates serialization of a property to a custom `PropertyHandler` |
| `#[Entrypoint]`                         | Class / Method       | Marks a class or method as an application entrypoint                |
| `#[ValueValidator]`                     | Method               | Marks a method on a Type class as a value validator                 |
| `#[DumpObject]`                         | Class                | Marks a class for debug dumping                                     |
| `#[RequiredButUnused]`                  | Parameter            | Marks a parameter that must exist but is intentionally unused       |
| `#[HasMarkdownDocumentation]`           | Class                | Indicates the class has associated Markdown documentation           |

---

### Singleton patterns

Two mechanisms exist for creating singletons, depending on the use case.

**`AsSingleton` trait** — for classes that cannot be registered as services (e.g., subtypes):

```php
class MyClass
{
    use AsSingleton;

    private function __construct() {}
}

$instance = MyClass::instance();
```

**`SingletonStore`** — for `readonly` data objects that have no constructor parameters and cannot use `AsSingleton`:

```php
$instance = SingletonStore::get(MyReadonlyDataObject::class);
// or via global function:
$instance = singleton(MyReadonlyDataObject::class);
```

---

### String handling

#### `CaseSensitiveString` / `CaseInsensitiveString`

Immutable string value objects with a fluent API. All modifying methods return a new instance.

```php
$string = new CaseSensitiveString('Hello World');

$string->startsWith('Hello');           // true
$string->endsWith('World');             // true
$string->contains('lo Wo');            // true
$string->equals('Hello World');        // true
$string->surroundedBy('"');            // false

$string->chopFromStart('Hello ');      // CaseSensitiveString('World')
$string->chopFromEnd(' World');        // CaseSensitiveString('Hello')

$string->truncateToCharLength(7);      // CaseSensitiveString('Hello …')
$string->truncateToByteLength(8);      // CaseSensitiveString('Hello …')

$string->regexMatch('/(\w+)/');        // ['Hello', 'Hello']
$string->regexMatchAll('/(\w+)/');     // [['Hello', 'Hello'], ['World', 'World']]
$string->regexReplace('/World/', 'PHP'); // CaseSensitiveString('Hello PHP')
```

`CaseInsensitiveString` extends `CaseSensitiveString` and overrides `startsWith`, `endsWith`, `contains`, and
`equals` to be case-insensitive.

#### `StringMaker`

A low-level singleton utility for turning any variable into a human-readable string. Used internally by the exception
system, but available directly:

```php
StringMaker::instance()->fromVariable(['a', 'b']);      // '["a", "b"]'
StringMaker::instance()->fromVariable(new MyObject());  // 'MyClass[42](id: 1, name: "foo")'
StringMaker::instance()->fromPattern('Hello %s', ['World']); // 'Hello "World"'
```

---

### Identifier

Converts identifier strings between naming conventions. Accepts camelCase, PascalCase, snake_case, kebab-case, and
space-separated input automatically.

```php
$id = new Identifier('compoundName');  // or 'CompoundName', 'compound_name', 'compound-name'

$id->toCamelCase();             // 'compoundName'
$id->toPascalCase();            // 'CompoundName'
$id->toSnakeCase();             // 'compound_name'
$id->toSnakeCase(toUpperCase: true);    // 'COMPOUND_NAME'
$id->toSnakeCase(maintainCase: true);   // preserves original casing
$id->toKebabCase();             // 'compound-name'
$id->toPhrase();                // 'compound name'

// With a prefix:
$id->toCamelCase('get');        // 'getCompoundName'
$id->toPascalCase('get');       // 'GetCompoundName'
```

The `IdentifierMaker` service provides named factory methods when the input format is known:

```php
$maker = new IdentifierMaker();
$maker->fromCamelCase('myVariable')->toKebabCase();  // 'my-variable'
$maker->fromKebabCase('my-variable')->toPascalCase(); // 'MyVariable'
```

---

### Collections

Three collection classes are provided, all implementing `ArrayAccess`, `Iterator`, and `Countable`.

**`BasicCollection<T>`** — a simple typed wrapper around an array:

```php
$collection = new BasicCollection([1, 2, 3]);
$collection->contains(2);   // true
count($collection);         // 3
```

**`GenericCollection<T>`** — extends `BasicCollection` with change tracking:

```php
$a = new stdClass();
$b = new stdClass();
$collection = new GenericCollection([$a, $b]);

$collection[] = new stdClass();
$collection->hasChanged();         // true
$collection->getAdditions();       // yields the new item
$collection->getDeletions();       // yields nothing
$collection->resetChangeTracking();
```

**`LazyGenericCollection<T>`** — a `GenericCollection` that defers loading until first access:

```php
$collection = new LazyGenericCollection(function() {
    return expensiveDatabaseCall();
});

// Data is only fetched when accessed:
count($collection);
```

**`ArrayCollection`** — a multi-value map indexed by arbitrary keys:

```php
$collection = new ArrayCollection();
$collection->add('fruit', 'apple');
$collection->add('fruit', 'pear');
$collection->add('vegetable', 'carrot');

$collection->atIndex('fruit');   // ['apple', 'pear']
$collection->indexes();          // ['fruit', 'vegetable']
$collection->atMaxCount();       // ['apple', 'pear']
```

---

### Events

**`BasicVote`** — a stoppable event for access-control decisions:

```php
class CanEditPost extends BasicVote {}

$vote = new CanEditPost();
dispatch($vote);

// Or throw automatically if not allowed:
allowElseThrow($vote, new AccessDeniedException());
```

Listeners set `$vote->allowedAccess` to `AllowedAccess::Allowed`, `AllowedAccess::Denied`, or `AllowedAccess::Unauthenticated`. Propagation stops as soon as a non-`Pending` value is set.

**`DebugInformation`** — a simple event for collecting debug messages:

```php
dispatch(new DebugInformation('Processing %s items', $count));
```

---

### Exceptions

All exceptions extend `BaseException`, which formats its message from a `printf`-style pattern:

```php
class NotFoundException extends BaseException
{
    public function __construct(string $id)
    {
        parent::__construct($id);
    }

    public function pattern(): string
    {
        return 'resource with id %s was not found';
    }
}
```

To attach a previous exception, override `previous()`:

```php
class WrappedException extends BaseException
{
    public function __construct(private readonly \Throwable $cause)
    {
        parent::__construct();
    }

    public function pattern(): string { return 'something went wrong'; }

    public function previous(): \Throwable|null { return $this->cause; }
}
```

Exceptions can implement `Suggestions` to provide hints to the developer:

```php
class MissingConfigException extends BaseException implements Suggestions
{
    public function suggestions(): array
    {
        return ['Check that your config file is loaded before calling config()'];
    }
}
```

---

### Floating-point utilities

`FloatingNumber` provides epsilon-based comparisons to avoid floating-point precision issues:

```php
FloatingNumber::areEqual(0.1 + 0.2, 0.3);           // true
FloatingNumber::isMoreThanOrEqual(1.0, 1.0);         // true
FloatingNumber::isBetweenInclusive(0.0, 0.5, 1.0);  // true
FloatingNumber::isZeroOrLess(0.0);                   // true
FloatingNumber::isMoreThanZero(0.0);                 // false

is_nihil(0.0000000001);  // true (global function shorthand)
```

---

### Other utilities

**`RectangleSides`** — CSS shorthand-style constructor for the four sides of a rectangle:

```php
new RectangleSides(10);              // top=10, right=10, bottom=10, left=10
new RectangleSides(10, 20);          // top=10, right=20, bottom=10, left=20
new RectangleSides(10, 20, 30);      // top=10, right=20, bottom=30, left=20
new RectangleSides(10, 20, 30, 40);  // top=10, right=20, bottom=30, left=40
```

**`File`** — a simple data object representing a file in memory:

```php
new File(content: $bytes, name: 'photo.jpg', mimetype: 'image/jpeg');
```

**`UrlReader`** — a service for making HTTP GET requests via cURL:

```php
$content = service(UrlReader::class)->read('https://example.com/api');
```

**`DateConstants`** — named integer constants for common time durations in seconds.

**`System::isFunctionAvailable(string $name)`** — checks whether a PHP function exists and is not disabled via `disable_functions`.

---

## Interfaces

`medas-core` defines the contracts that other packages implement. Key interfaces include:

| Interface                          | Purpose                                                  |
|------------------------------------|----------------------------------------------------------|
| `ServiceManager`                   | Resolves and binds service implementations               |
| `ObjectInstantiator`               | Instantiates classes with automatic dependency injection |
| `EventDispatcher`                  | Dispatches events to registered listeners                |
| `CacheManager` / `Cache`           | Cache retrieval and storage                              |
| `ConfigManager`                    | Config value access                                      |
| `Collection` / `ManagedCollection` | Typed iterable collections                               |
| `TracksChanges`                    | Change tracking on collections or objects                |
| `Validator`                        | Value validation                                         |
| `Serializer` / `StringSerializer`  | Serialization contracts                                  |
| `UuidProvider` / `Uuid`            | UUID generation and representation                       |

---

## Running tests

```bash
composer install
vendor/bin/phpunit
```

---

## Changelog

### 3.0.0

- `CaseSensitiveString` is now `readonly`; all modifying methods return a new instance instead of mutating `$this`
- `CaseSensitiveString::chopFromStart` and `chopFromEnd` now return `self` instead of `bool`
- `CaseSensitiveString::regexReplace` now returns `self` instead of `int` (replacement count)
- `BaseException` removed `arguments()` and `setPrevious()`; use `previous()` override instead
- `GenericCollection` now extends `BasicCollection`; duplicate iterator/array-access code removed
- `Identifier` now accepts camelCase, PascalCase, snake_case, and kebab-case input in addition to space-separated strings
- `SingletonStore::get` now throws `CannotInstantiateClassWithParameters` for classes with constructor parameters
- `LazyGenericCollection` now throws `NoInitializerHasBeenSet` when accessed without a loader

### 2.0.x — 2.1.x

See git history.
