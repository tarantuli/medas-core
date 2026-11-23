<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Turns a class into a singleton: `instance()` creates one the first time, and returns it from then on. Lighter than a
 * @class(Medas\Core\Attributes\Service), and available before the service manager is, which is why packages use it.
 *
 * The constructor becomes protected, so other code can't create more. A class can declare a public one instead, like
 * @class(Medas\Core\StringMaker) does.
 *
 * Each class has its own instance, subclasses too: if `B` extends `A`, `B::instance()` returns a `B`.
 *
 * @assumes A subclass's constructor needs no arguments either.
 * @state Keeps the instances for the lifetime of the process.
 */
trait AsSingleton
{
    // Keyed by class, as a subclass shares this static property with the class that uses the trait
    private static array $instances = [];

    /**
     * Returns the instance of the class it's called on, created without arguments the first time.
     */
    public static function instance(): static
    {
        return self::$instances[static::class] ??= new static();
    }

    protected function __construct()
    {
    }
}
