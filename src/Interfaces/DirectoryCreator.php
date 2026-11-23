<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Creates directories.
 *
 * The default implementation is @class(Medas\FileSystem\DirectoryCreator).
 */
interface DirectoryCreator
{
    /**
     * Creates the directory, and any missing parent directories. Does nothing when the directory exists already,
     * also when another process has just created it.
     */
    public function create(string $path): void;
}
