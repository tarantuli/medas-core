<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Loads PHP files, so the classes in them are declared, for example to find classes by their attributes.
 *
 * The default implementation is @class(Medas\FileSystem\FileLoader), which only loads files from the allowed
 * directories.
 */
interface FileLoader
{
    /**
     * Loads every PHP file in the directory and its subdirectories.
     *
     * @sideEffect Runs every file, including any code outside class declarations.
     */
    public function load(string $directory): void;
}
