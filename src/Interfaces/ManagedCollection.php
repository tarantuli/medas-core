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

    public function getModifications(): iterable;

    public function getDeletions(): iterable;
}
