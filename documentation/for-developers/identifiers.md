# Identifiers

The `Identifier` class parses a string identifier in any common casing format and converts it to any other. It is useful when code needs to transform names between conventions — for example, turning a snake_case config key into a camelCase property name.

`IdentifierAnalyzer` determines the format of a given string. `Identifier` uses it internally, so you rarely need to call `IdentifierAnalyzer` directly.

## Supported formats

| Format | Example |
|---|---|
| `CamelCase` | `myVariableName` |
| `PascalCase` | `MyVariableName` |
| `snake_case` | `my_variable_name` |
| `kebab-case` | `my-variable-name` |
| `Space case` | `my variable name` |

Detection priority: if the string contains a `-`, it is treated as kebab-case. If it contains a `_`, snake_case. If it contains a space, space case. Otherwise, the first character determines pascal vs camel.

An empty string throws `EmptyIdentifier`.

## Converting an identifier

```php
$identifier = new Identifier('my-variable-name');

$identifier->toCamelCase();   // myVariableName
$identifier->toPascalCase();  // MyVariableName
$identifier->toSnakeCase();   // my_variable_name
$identifier->toKebabCase();   // my-variable-name
$identifier->toPhrase();      // my variable name
```

## Case options

`toSnakeCase()`, `toKebabCase()`, and `toPhrase()` accept three mutually exclusive boolean flags:

| Parameter | Default | Effect |
|---|---|---|
| `$toLowerCase` | `true` | Output is lowercased |
| `$toUpperCase` | `false` | Output is uppercased |
| `$maintainCase` | `false` | Words are joined as-is without changing case |

## Adding a prefix

`toCamelCase()` and `toPascalCase()` accept an optional `$prefix` that is prepended as the first word:

```php
$identifier = new Identifier('created_at');
$identifier->toCamelCase('get');   // getCreatedAt
$identifier->toPascalCase('get');  // GetCreatedAt
```
