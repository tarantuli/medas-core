<?php

declare(strict_types=1);

namespace Medas\Core;

use Medas\ServiceManager\BasePackage;

class CorePackage extends BasePackage
{
    public function dependencies(): array
    {
        return [];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
