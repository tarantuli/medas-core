<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A validator checks whether a given value is valid.
 */
interface Validator
{
    public function isValid(mixed $value): bool;
}
