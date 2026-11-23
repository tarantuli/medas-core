<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A service implementing this interface lists the directories with the entities a package needs to have stored, like
 * the `User` entity of the users package.
 *
 * The entity manager and the migration builder add these directories to the configured entity directories, so the
 * entities in them are known to both, and migrations cover them too.
 */
interface PackageEntities
{
    /** @return string[] Absolute paths */
    public function directories(): array;
}
