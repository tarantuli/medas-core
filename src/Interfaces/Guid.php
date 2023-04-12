<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface Guid extends \Stringable
{
    public function toBytes(): string;
}
