<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface FileFinder
{
    /**
     * Recursively finds all files matching the given regexp pattern in the given directory.
     */
    public function find(string $directory, string $matchPattern, string|null $ignorePattern = null): iterable;

    /**
     * Recursively finds all files with the given extension in the given directory.
     */
    public function findByExtension(string $directory, string $extension, string|null $ignorePattern = null): iterable;
}
