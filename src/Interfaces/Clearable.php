<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Generic interface that can be used to mark objects that are clearable.
 *
 * Specifically, @class(Medas\Core\Interfaces\Cache) instances that implement this are cleared when clearAll() on the
 * @class(Medas\Core\Interfaces\CacheManager) is called.
 */
interface Clearable
{
    public function clear(): void;
}
