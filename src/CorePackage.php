<?php

declare(strict_types=1);

namespace Medas\Core;

use Medas\ServiceManager\{BasePackage, ServiceConfig};

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

    public function initialize(ServiceConfig $config): void
    {
        require_once __DIR__ . '/GlobalFunctions.php';

        parent::initialize($config);
    }
}
