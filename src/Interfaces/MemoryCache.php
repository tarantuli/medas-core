<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A cache that keeps values in the memory of the process, for the rest of the request or the lifetime of a worker.
 *
 * The cache manager creates one as the `'memory'` cache when it's first requested, from the class bound to this
 * interface. @class(Medas\Cache\MemoryCache) is that class when the cache package is installed.
 *
 * @assumes Implementations can be created with `new` and without arguments, because the cache manager creates the
 *          `'memory'` cache that way.
 */
interface MemoryCache extends Cache, NonPersistentCache
{
}
