<?php

declare(strict_types=1);

use Medas\Core\CorePackage;
use Medas\ServiceManager\{ServiceConfig, ServiceManager};

chdir(__DIR__);

new ServiceManager(function (): ServiceConfig {
    $config = new ServiceConfig();

    $config->addPackage(CorePackage::instance());

    return $config;
});
