# Entrypoints

The `#[Entrypoint]` attribute marks the most important public classes and methods of a package. It serves as a navigational aid — both for developers discovering a package for the first time, and for tooling that can list or highlight entrypoints automatically.

Apply it to the class or method a new user should look at first. Not every public class needs it; only the ones that represent the primary way to interact with the package.

## Requirements

- The attribute can be applied to classes (`TARGET_CLASS`) and methods (`TARGET_METHOD`).
- Mark only the most meaningful public entrypoints — not every public class or method.
- A package may have multiple entrypoints if it genuinely offers distinct starting points.

## Example

```php
use Medas\Core\Attributes\Entrypoint;

#[Entrypoint]
class IdentifierMaker
{
    #[Entrypoint]
    public function fromCamelCase(string $camelCase): Identifier { ... }
}
```
