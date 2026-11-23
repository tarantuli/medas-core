<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks a class as a service: the service manager creates one instance of it for the whole process, and injects it
 * wherever a parameter's type is provided by it.
 *
 * Only non-abstract classes in the source directory of a registered package are found. Attributes that extend this
 * one mark services too, like `Medas\Routing\Route`.
 *
 * When a service is injected as a dependency, it's injected as a lazy object by default: its constructor, and with it
 * the resolution of its own dependencies, runs on first access to one of its properties. That takes a service manager
 * that implements @class(Medas\Core\Interfaces\ResolvesLazily) and an object instantiator that implements
 * @class(Medas\Core\Interfaces\InstantiatesLazily). Set `$lazy` to `false` for services whose constructor must run
 * when they're injected, for example because it has side effects that other code relies on. Services that can't be
 * lazy, like classes extending internal PHP classes or without a public constructor with parameters, are always
 * instantiated directly.
 *
 * @cache Which classes are services is part of the cached service configuration, so adding or removing this attribute
 *        only takes effect after the caches are cleared.
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
