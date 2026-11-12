<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

/**
 * Config option `core.trace-argument-max-length`: the number of characters of a string argument that `TraceFormatter`
 * shows in a stack trace.
 */
#[Service]
readonly class TraceArgumentMaxLength implements ConfigOption
{
    public function __construct(
        private CoreGroup $group,
    )
    {
    }

    public function group(): ConfigGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'trace-argument-max-length';
    }

    public function description(): string
    {
        return 'Maximum number of characters for string arguments printed in stack traces';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 156;
    }
}
