<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Converts objects of one class to an array and back, for a class marked with
 * @class(Medas\Core\Attributes\ObjectToArrayHandler). Implementations are services.
 *
 * Example:
 *
 * - @class(Medas\RamseyUuidBridge\UuidProvider) converts UUIDs to an array with their bytes.
 */
interface ObjectToArrayHandler
{
    public function toArray(object $value): array;

    /**
     * @param array $value What `toArray()` returned
     */
    public function toObject(array $value): object;
}
