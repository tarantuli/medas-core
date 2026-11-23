<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks caches whose entries don't outlive the process, like memory caches and caches that remember nothing.
 *
 * When every registered cache is non-persistent, filling caches in advance is pointless, so the services that
 * implement @class(Medas\Core\Interfaces\PrimesCache) aren't asked to.
 */
interface NonPersistentCache
{
}
