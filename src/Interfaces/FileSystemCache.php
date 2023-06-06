<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface FileSystemCache extends Cache
{
    public function baseDirectory(): string;
}
