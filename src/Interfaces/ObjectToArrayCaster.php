<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Casts an object to an associative array, recursively converting nested objects
 */
interface ObjectToArrayCaster
{
    public function cast(object $value): array;
}
