# Process objects

A process object carries everything a multi-step process needs: its input, any intermediate state produced along the way, and the final result. It is passed between services, each of which reads from it and writes its output back to it.

This pattern keeps each processing service focused on one step, avoids long argument lists, and makes the full state of an in-progress operation inspectable at any point.

## Requirements

- Must not be `readonly` — its properties are written to by the services that process it.
- Input given at construction should be `readonly` to prevent accidental mutation by processing steps.
- All properties should be `public` so that processing services can read and write freely without requiring getters and setters.
- Must not contain business logic. It holds state; services perform the work.
- Must not depend on services or the service manager.
- Should be named after the process it represents, e.g. `FormattingJob`, `RenderJob`, `ImportJob`.

## Example

```php
class FormattingJob
{
    public TokenCollection $tokens;
    public TokenTree $tree;
    public array $warnings = [];

    public function __construct(
        public string           $code,
        public readonly Settings $settings,
    ) {
    }
}
```

The services in the pipeline then each accept the job, do their work, and write their results back:

```php
#[Service]
readonly class Tokenizer
{
    public function tokenize(FormattingJob $job): void
    {
        $job->tokens = $this->parse($job->code);
    }
}

#[Service]
readonly class TreeBuilder
{
    public function build(FormattingJob $job): void
    {
        $job->tree = $this->buildTree($job->tokens);
    }
}
```

## Contrast with data objects

A [data object](data-objects) is immutable and represents a finished piece of data. A process object is mutable and represents an ongoing computation. Once a process is complete, its result may be extracted into a data object if it needs to be passed further.
