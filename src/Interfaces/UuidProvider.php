<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Creates @class(Medas\Core\Interfaces\Uuid) objects: new ones, and ones from their readable form or their bytes.
 *
 * Example:
 *
 * - @class(Medas\RamseyUuidBridge\UuidProvider) creates time-ordered version 7 UUIDs with ramsey/uuid.
 */
interface UuidProvider
{
    public function create(): Uuid;

    /**
     * @param string $bytes What `Uuid::toBytes()` returned
     */
    public function fromBytes(string $bytes): Uuid;

    /**
     * Throws when `$string` isn't a UUID. Which exception that is depends on the implementation.
     *
     * @param string $string The readable form, as `Uuid::__toString()` returns it
     */
    public function fromString(string $string): Uuid;
}
