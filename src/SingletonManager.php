<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Prefer to use a ServiceManager implementation or an application using AsSingleton.
 *
 * This manager should be used when you want to have singleton instances of readonly data object, which don't fit
 * service characteristics, nor cannot be used with AsSingleton (due to the readonly nature).
 */
#[Attributes\Service]
class SingletonManager
{
    private array $objects = [];

    /**
     * The return value is an object of type $class. This is specified in PhpStorm in .phpstorm.meta.php
     */
    public function get(string $class): object
    {
        if (!isset($this->objects[$class])) {
            $this->objects[$class] = new $class();
        }

        return $this->objects[$class];
    }
}
