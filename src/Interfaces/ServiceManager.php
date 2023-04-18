<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ServiceManager
{
    /**
     * The return value  is an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
     */
    public function resolve(string $type): object;

    /**
     * Looks for classes that implement the given type. If none are found, it returns null. If multiple implementors
     * are found, and none is explicitly bound using bindImplementor(), it throws an exception.
     */
    public function findImplementingClass(string $type): string|null;

    /**
     * Binds the given object as the implementation for the given types. E.g. if resolve() is called with any of these
     * types, $implementor will be resolved.
     */
    public function bindImplementation(object $implementation, string ...$forTypes): self;
}
