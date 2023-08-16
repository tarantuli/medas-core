<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Generic interface that can be used to mark objects that are clearable.
 *
 * Specifically, Cache instances that implement this are cleared when clearAll() on the CacheManager is called.
 */
interface Clearable
{
    public function clear(): void;
}
