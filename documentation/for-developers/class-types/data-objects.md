# Data objects

A data object is a typed container for other data. It is immutable, has no business logic, and can be freely passed around between services.

## Requirements

- Must be `readonly`.
- Constructor parameters are its data. Use constructor property promotion.
- Must not have methods that do anything other than add, remove, return, or filter the data it holds.
- Must not depend on services or the service manager.
- Must not perform I/O, validation beyond type enforcement, or any side effects.

## Example

```php
readonly class UploadedFile
{
    public function __construct(
        public string $originalName,
        public string $mimeType,
        public int    $sizeInBytes,
        public string $temporaryPath,
    ) {
    }
}
```

## Collections as data objects

A data object may wrap a collection of other data objects. It should expose only the minimum interface needed to access and filter that data:

```php
readonly class UploadedFileCollection
{
    public function __construct(
        /** @var UploadedFile[] */
        private array $files = [],
    ) {
    }

    /** @return UploadedFile[] */
    public function all(): array
    {
        return $this->files;
    }

    public function withMimeType(string $mimeType): self
    {
        return new self(array_filter(
            $this->files,
            fn(UploadedFile $file) => $file->mimeType === $mimeType,
        ));
    }
}
```
