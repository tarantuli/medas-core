<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This interface marks caches that do not persist data between requests, e.g. in memory caches or no-op caches
 */
interface NonPersistentCache
{
}
