<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface Validator
{
    public function isValid(mixed $value): bool;
}
