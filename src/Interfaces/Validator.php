<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Checks whether a value is valid.
 *
 * A @class(Medas\Core\Interfaces\ConfigOption) that implements it has its configured values checked before they're
 * used.
 */
interface Validator
{
    public function isValid(mixed $value): bool;
}
