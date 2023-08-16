<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/** See ConfigOption for more information */
interface ConfigGroup
{
    public function parent(): ConfigGroup|null;

    public function name(): string;
}
