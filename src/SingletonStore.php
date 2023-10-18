<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Prefer to use a ServiceManager implementation or apply AsSingleton to get a singleton instance of a class.
 *
 * This store should be used when you want to have singleton instances of readonly data object, which don't fit
 * service characteristics, nor cannot be used with AsSingleton (due to the readonly nature).
 */
class SingletonStore
{
    private static array $objects = [];

    /**
     * The return value is an object of type $class. This is specified in PhpStorm in .phpstorm.meta.php
     */
    public static function get(string $class): object
    {
        if (!isset(static::$objects[$class])) {
            static::$objects[$class] = new $class();
        }

        return static::$objects[$class];
    }
}
