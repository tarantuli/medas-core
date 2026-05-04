<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ObjectToArrayHandler
{
    public function toArray(object $value): array;

    public function toObject(array $value): object;
}
