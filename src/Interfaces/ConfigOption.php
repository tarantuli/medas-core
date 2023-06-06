<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ConfigOption
{
    public function group(): ConfigGroup;

    public function name(): string;

    /**
     * A single line describing what this option does. It should start with a capital and not end with a dot
     */
    public function description(): string;

    public function hasDefault(): bool;

    public function default(): mixed;
}
