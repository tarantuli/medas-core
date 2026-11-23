<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Stores file contents under a path, wherever the implementation keeps them, so code can read and write files
 * without knowing where they are.
 *
 * The methods don't throw when a path doesn't exist: they return `false` or `null`.
 *
 * Example:
 *
 * - @class(Medas\HttpFileClient\Controller) keeps the files on a remote http-file-server.
 */
interface DataStorage
{
    public function exists(string $path): bool;

    /**
     * Returns whether the file was deleted.
     */
    public function delete(string $path): bool;

    /**
     * Returns the contents of the file, or `null` when it doesn't exist.
     */
    public function content(string $path): string|null;

    /**
     * Returns the size of the file in bytes, or `null` when it doesn't exist.
     */
    public function size(string $path): int|null;

    /**
     * Returns when the file was last changed, or `null` when it doesn't exist.
     */
    public function modificationTime(string $path): \DateTime|null;

    /**
     * Stores `$content` under `$path`, replacing what was there, and returns whether that worked.
     *
     * @param \DateTime|null $modificationTime The time to record as the last change, instead of now
     */
    public function store(
        string         $path,
        string         $content,
        \DateTime|null $modificationTime = null,
    ): bool;
}
