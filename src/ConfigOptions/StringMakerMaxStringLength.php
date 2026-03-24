<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

#[Service]
readonly class StringMakerMaxStringLength implements ConfigOption
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
        return 'string-maker-max-string-length';
    }

    public function description(): string
    {
        return 'The maximum character length of each argument when formatting a pattern string via StringMaker';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 1000;
    }
}
