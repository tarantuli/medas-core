<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface FileLoader
{
    /**
     * Loads all PHP files in the given directory.
     */
    public function load(string $directory): void;
}
