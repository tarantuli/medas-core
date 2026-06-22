<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Populates an object's properties from an associative array, recursively casting nested arrays into typed objects
 */
interface ArrayToObjectCaster
{
    public function cast(array $values, string $className);
}
