<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An @class(Medas\Core\Interfaces\ObjectInstantiator) that can create lazy objects, whose constructor arguments are
 * resolved and whose constructor is called only when the object is first used.
 *
 * This is a separate interface, so object instantiators that don't implement it keep working: the service manager
 * then instantiates every service right away.
 *
 * @see ResolvesLazily
 */
interface InstantiatesLazily
{
    /**
     * Returns a lazy object of `$type`, or a regular instance when the type can't, or mustn't, be lazy. A class marked
     * with `#[Service(lazy: false)]` must always be instantiated right away.
     *
     * No arguments can be given: they're all resolved, when the object is initialised. So for a lazy object, the
     * exceptions `instantiate()` throws, and those of the constructor itself, are thrown where it's first used.
     *
     * The return value is an object of type `$type`, which PhpStorm knows from `.phpstorm.meta.php`.
     */
    public function instantiateLazy(string $type): object;
}
