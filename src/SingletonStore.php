<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Keeps one instance per class, for readonly data objects that aren't services and can't use
 * @class(Medas\Core\AsSingleton), whose static property a readonly class can't have. `singleton()` calls it.
 *
 * For anything else, prefer a service or `AsSingleton`.
 *
 * @state Keeps the instances for the lifetime of the process.
 */
class SingletonStore
{
    private static array $objects = [];

    /**
     * Returns the instance of `$class`, created without arguments the first time.
     *
     * @throws Exceptions\CannotInstantiateClassWithParameters When the constructor has required parameters.
     */
    /*
     * The return value is specified for PhpStorm using .phpstorm.meta.php
     */
    public static function get(string $class): object
    {
        if (!isset(static::$objects[$class])) {
            $reflection = new \ReflectionClass($class);
            $constructor = $reflection->getConstructor();

            if ($constructor && $constructor->getNumberOfRequiredParameters() > 0) {
                throw new Exceptions\CannotInstantiateClassWithParameters($reflection);
            }

            static::$objects[$class] = new $class();
        }

        return static::$objects[$class];
    }
}
