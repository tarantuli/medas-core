<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ConfigGroup
{
    public function parent(): ConfigGroup|null;

    public function name(): string;
}
