<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A collection that also maintains its additions and deletions. See @class(Medas\Core\Interfaces\Collection) for more
 * information.
 */
interface ManagedCollection extends SettableCollection
{
    public function getAdditions(): iterable;

    public function getDeletions(): iterable;

    /**
     * This should return the elements that have changed order
     */
    public function getMovements(): iterable;

    /**
     * This should return the keys and values that have changed value
     */
    public function getModifications(): iterable;
}
