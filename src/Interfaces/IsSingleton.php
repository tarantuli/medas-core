<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Classes that implement this interface should not be instantiated more than once, and this single instance should be
 * fetchable by calling ```instance()```.
 *
 * This is meant for class types that do not represent instance data, which should be data classes.
 * They should also not be actionable, as that should be @class(Medas\Core\Attributes\Service) classes.
 *
 * The @class(Medas\Core\AsSingleton) trait can be used to implement this interface.
 *
 * Examples:
 *
 * - @class(Medas\ServiceManager\Package) instances are classes that contain configuration options for
 * the whole package.
 */
interface IsSingleton
{
    public static function instance(): self;
}
