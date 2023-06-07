<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ConfigManager
{
    public function getValue(string $path): mixed;

    public function hasValue(string $path): bool;

    public function readEnv(string $filePath, string $name = null): self;
}
