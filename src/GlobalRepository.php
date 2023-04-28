<?php

declare(strict_types=1);

namespace Medas\Core;

class GlobalRepository
{
    private static Interfaces\ServiceManager $serviceManager;
    private static Interfaces\ObjectInstantiator $objectInstantiator;

    public static function serviceManager(): Interfaces\ServiceManager
    {
        if (!isset(self::$serviceManager)) {
            throw new Exceptions\NoServiceManagerRegistered();
        }

        return self::$serviceManager;
    }

    public static function setServiceManager(Interfaces\ServiceManager $serviceManager): void
    {
        self::$serviceManager = $serviceManager;
    }

    public static function objectInstantiator(): Interfaces\ObjectInstantiator
    {
        if (!isset(self::$objectInstantiator)) {
            throw new Exceptions\NoObjectInstantiatorRegistered();
        }

        return self::$objectInstantiator;
    }

    public static function setObjectInstantiator(Interfaces\ObjectInstantiator $objectInstantiator): void
    {
        self::$objectInstantiator = $objectInstantiator;
    }
}
