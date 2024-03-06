<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Packages marked with this interface should have a method ```primeCache()``` that should be called by the service manager
 * after composer installs or updates. The method should perform expensive calculations that are cached.
 */
interface PrimesCache
{
    public function primeCache(): void;
}
