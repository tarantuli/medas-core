<?php

declare(strict_types=1);

use Medas\Core\CorePackage;
use Medas\ServiceManager\ServiceManager;

chdir(__DIR__);

require_once 'vendor/autoload.php';

ServiceManager::get()
    ->addPackage(CorePackage::instance());
