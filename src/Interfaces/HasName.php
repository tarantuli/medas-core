<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks objects with a name.
 */
interface HasName
{
    public function name(): string;
}
