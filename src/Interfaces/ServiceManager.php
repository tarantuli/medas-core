<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The service manager is responsible for finding and maintaining service classes and their instances.
 *
 * The default implementation is @class(Medas\ServiceManager\ServiceManager).
 */
interface ServiceManager
{
    /**
     * The return value is an object of type `$type`.
     */
    /*
     *  This is specified in PhpStorm in .phpstorm.meta.php
     */
    public function resolve(string $type): object;

    /**
     * Looks for classes that implement the given type. If none are found, it returns null. If multiple implementors
     * are found, and none is explicitly bound using ```bindImplementation()```, it throws an exception.
     */
    public function findImplementingClass(string $type): string|null;
}
