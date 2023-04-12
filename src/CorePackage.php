<?php

declare(strict_types=1);

namespace Medas\Core;

use Medas\ServiceManager\{AsSingleton, BasePackage};

class CorePackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
