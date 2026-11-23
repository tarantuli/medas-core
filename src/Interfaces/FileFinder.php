<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Lists the files in a directory and all its subdirectories.
 *
 * The default implementation is @class(Medas\FileSystem\FileFinder).
 */
interface FileFinder
{
    /**
     * Returns the full paths of the files that match `$matchPattern`.
     *
     * @param string      $matchPattern  A regular expression, matched against the full path, not just the file name
     * @param string|null $ignorePattern A regular expression, matched against the full path. Matching files are left
     *                                   out.
     *
     * @return iterable<string>
     */
    public function find(string $directory, string $matchPattern, string|null $ignorePattern = null): iterable;

    /**
     * Returns the full paths of the files with the given extension, matched case-insensitively.
     *
     * @param string      $extension     Without the leading dot, like `'php'`
     * @param string|null $ignorePattern A regular expression, matched against the full path. Matching files are left
     *                                   out.
     *
     * @return iterable<string>
     */
    public function findByExtension(string $directory, string $extension, string|null $ignorePattern = null): iterable;
}
