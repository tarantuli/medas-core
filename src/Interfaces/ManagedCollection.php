<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A collection that also maintains its additions and deletions. See Collection for more information.
 */
interface ManagedCollection extends Collection
{
    public function getAdditions(): array;

    public function getDeletions(): array;
}
