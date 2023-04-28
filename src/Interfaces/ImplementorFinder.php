<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ImplementorFinder
{
    /** @return object[] */
    public function find(string $interface): array;
}
