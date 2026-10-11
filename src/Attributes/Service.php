<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks a class as a service.
 *
 * When a service is injected as a dependency, it is injected as a lazy object by default: its constructor (and
 * with it the resolution of its own dependencies) runs on first access to one of its properties. Set ```$lazy``` to
 * false for services whose constructor must run when they are injected, e.g. because it has side effects that other
 * code relies on. Services that can't be lazy (classes extending internal PHP classes, or without a public
 * constructor with parameters) are always instantiated directly.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class Service
{
    /*
     * Not promoted, so the default also applies to attributes extending this one that don't call this constructor
     * (e.g. Medas\Routing\Route).
     */
    public bool $lazy = true;

    public function __construct(
        bool $lazy = true,
    )
    {
        $this->lazy = $lazy;
    }
}
