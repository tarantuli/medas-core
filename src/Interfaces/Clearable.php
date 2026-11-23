<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks objects that can be emptied, like caches.
 *
 * A @class(Medas\Core\Interfaces\Cache) that implements it is cleared by `CacheManager::clearAll()`, which runs after
 * a `composer install` and on `services:clear-caches`. A cache that doesn't implement it keeps its entries then.
 */
interface Clearable
{
    /**
     * Removes everything, so the object behaves as if it were new.
     */
    public function clear(): void;
}
