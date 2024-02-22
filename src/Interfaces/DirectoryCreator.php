<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface DirectoryCreator
{
    /**
     * Creates the directory with the given path.
     */
    public function create(string $path): void;
}
