<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Interfaces\Guid;

interface GuidProvider
{
    public function create(): Guid;

    public function fromBytes(string $bytes): Guid;

    public function fromString(string $string): Guid;
}
