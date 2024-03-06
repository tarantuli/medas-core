<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A Guid object should be castable to a readable string. ```toBytes()``` should return a byte representation string for
 * storage purposes.
 */
interface Guid extends \Stringable
{
    public function toBytes(): string;
}
