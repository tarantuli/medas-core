<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An @class(Medas\Core\Interfaces\ObjectInstantiator) that can create lazy objects, whose constructor arguments are
 * resolved and whose constructor is called on first access to one of their properties.
 *
 * This is a separate interface, so object instantiators that don't implement it keep working.
 */
interface InstantiatesLazily
{
    /**
     * Returns a lazy object of the given type, or a regular instance when the type can't (or must not) be lazy.
     *
     * The return value is an object of type `$type`.
     */
    public function instantiateLazy(string $type): object;
}
