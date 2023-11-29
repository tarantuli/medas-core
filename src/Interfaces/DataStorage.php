<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface DataStorage
{
    public function exists(string $path): bool;

    public function delete(string $path): bool;

    public function content(string $path): string|null;

    public function size(string $path): string|null;

    public function modificationTime(string $path): \DateTime|null;

    public function creationTime(string $path): \DateTime|null;

    public function store(
        string    $path,
        string    $content,
        \DateTime $modificationTime = null,
        \DateTime $creationTime = null
    ): string|null;
}
