<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A service implementing this interface publishes the directories where entities live that should be stored to make a
 * package work. Migration builders must scan these directories and process the entities therein.
 */
interface PackageEntities
{
    public function directories(): array;
}
