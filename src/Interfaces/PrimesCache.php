<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\ServiceManager\CachePrimer;

/**
 * Marks services that can fill their caches in advance, so the first requests after a deployment don't have to.
 *
 * After a `composer install` or `composer update`, every service that implements it is resolved, and `primeCache()`
 * is called on it. That only happens when a persistent cache is registered: with only
 * @class(Medas\Core\Interfaces\NonPersistentCache) caches, the results would be lost when the process ends.
 *
 * @see CachePrimer
 */
interface PrimesCache
{
    /**
     * Performs the expensive calculations whose results are cached, and stores them.
     *
     * @assumes It runs in a command-line process, so there's no request, and no request-specific state to rely on.
     */
    public function primeCache(): void;
}
