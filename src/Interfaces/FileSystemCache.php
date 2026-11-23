<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\ServiceManager\Cache\DirectoriesToClear;

/**
 * A cache that stores its entries as files in one directory, so other processes can empty it: a `composer install`
 * or `services:clear-caches` from the command line clears the entries the web server uses too.
 *
 * @class(Medas\Cache\FileSystemCache) is the implementation in the cache package.
 *
 * @see DirectoriesToClear
 */
interface FileSystemCache extends Cache
{
    /**
     * The directory that holds every entry of this cache, and nothing else, because emptying the cache deletes
     * everything in it. A relative path is relative to the project root.
     */
    public function baseDirectory(): string;

    /**
     * Whether the base directory is emptied after a `composer install` and on `services:clear-caches`. Return `false`
     * for data that has to survive those.
     */
    public function clearCacheOnInstall(): bool;
}
