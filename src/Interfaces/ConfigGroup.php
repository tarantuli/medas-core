<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ConfigGroup extends IsSingleton
{
    public function parent(): ConfigGroup|null;

    public function name(): string;
}
