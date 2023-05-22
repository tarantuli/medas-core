<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ManagedCollection extends Collection
{
    public function getAdditions(): array;

    public function getDeletions(): array;
}
