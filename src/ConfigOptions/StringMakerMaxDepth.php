<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

#[Service]
readonly class StringMakerMaxDepth implements ConfigOption
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
        return 'string-maker-max-depth';
    }

    public function description(): string
    {
        return 'The maximum recursion depth for StringMaker before returning a placeholder value';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 100;
    }
}
