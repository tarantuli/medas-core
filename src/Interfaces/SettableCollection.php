<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface SettableCollection
{
    public function setData(array $data): void;
}
