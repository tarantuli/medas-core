<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Implementor finder should take the name of an interface and return an array of @class(Medas\Core\Attributes\Service)
 * names that implement the given interface.
 */
interface ImplementorFinder
{
    /** @return class-string[] */
    public function find(string $interface): array;
}
