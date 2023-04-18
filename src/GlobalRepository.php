<?php

declare(strict_types=1);

namespace Medas\Core;

class GlobalRepository
{
    private static Interfaces\ServiceManager|null $serviceManager = null;
    private static Interfaces\ObjectInstantiator|null $objectInstantiator = null;

    public static function serviceManager(): Interfaces\ServiceManager|null
    {
        return self::$serviceManager;
    }

    public static function setServiceManager(Interfaces\ServiceManager $serviceManager): void
    {
        self::$serviceManager = $serviceManager;
    }

    public static function objectInstantiator(): Interfaces\ObjectInstantiator|null
    {
        return self::$objectInstantiator;
    }

    public static function setObjectInstantiator(Interfaces\ObjectInstantiator $objectInstantiator): void
    {
        self::$objectInstantiator = $objectInstantiator;
    }
}
