<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A Uuid provider should not only be able to create them from scratch, but also from their readable string
 * representation (see ```Uuid::__toString()```) and their byte representation (see ```Uuid::toBytes()```).
 */
interface UuidProvider
{
    public function create(): Uuid;

    public function fromBytes(string $bytes): Uuid;

    public function fromString(string $string): Uuid;
}
