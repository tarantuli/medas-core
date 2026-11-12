<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup};

/**
 * Config group `'core'`, which holds the config options of the core package, so their paths start with `core.`.
 */
#[Service]
readonly class CoreGroup implements ConfigGroup
{
    public function parent(): ConfigGroup|null
    {
        return null;
    }

    public function name(): string
    {
        return 'core';
    }
}
