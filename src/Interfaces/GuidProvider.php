<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A guid provider should not only be able to create them from scratch, but also from their readable string
 * representation (see ```Guid::__toString()```) and their byte representation (see ```Guid::toBytes()```).
 */
interface GuidProvider
{
    public function create(): Guid;

    public function fromBytes(string $bytes): Guid;

    public function fromString(string $string): Guid;
}
