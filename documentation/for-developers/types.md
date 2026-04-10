# Types

Type attributes annotate entity properties to describe what kind of data they hold and what constraints apply. They are used by other packages — such as the entity manager and serializers — to understand how to store, validate, and convert property values.

All type attributes extend `BaseType` and are applicable to properties (`TARGET_PROPERTY`).

## Available types

| Type | Description |
|---|---|
| `Text` | A string of text with optional min/max length in characters |
| `Binary` | Raw binary data with optional min/max length in bytes |
| `Integer` | An integer with optional min/max value |
| `FloatingPoint` | A floating-point number |
| `Boolean` | A boolean value |
| `DateTime` | A date/time value with optional min/max and timezone |
| `EmailAddress` | A text value validated as an email address |
| `Uuid` | A 16-byte UUID stored as binary |
| `Relation` | A reference to another entity class |
| `Collection` | A typed collection of related entities |
| `File` | A reference to a stored file (extends `Relation`) |

## Example

```php
use Medas\Core\Types\{Boolean, DateTime, EmailAddress, Integer, Relation, Text, Uuid};

class User
{
    #[Uuid]
    public string $id;

    #[Text(minLength: 1, maxLength: 100)]
    public string $name;

    #[EmailAddress]
    public string $email;

    #[Integer(minValue: 0, maxValue: Integer::UNSIGNED_1_BYTE_MAX)]
    public int $loginAttempts;

    #[Boolean]
    public bool $isActive;

    #[DateTime]
    public \DateTimeImmutable $createdAt;

    #[Relation(entity: Role::class)]
    public Role $role;
}
```

## Requirements

- Type attributes are applied to properties only (`TARGET_PROPERTY`).
- Each property should have at most one type attribute.
- Use the most specific type available — prefer `EmailAddress` over `Text` for email fields, `Uuid` over `Binary` for UUIDs.
- `Relation` takes the fully qualified class name of the related entity.
- `Collection` takes both the collection class name and the content entity class name.
- `Integer` provides constants for common database storage boundaries (e.g. `Integer::UNSIGNED_4_BYTE_MAX`).
