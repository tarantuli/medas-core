<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A collection which allows setting of the data members using ```setData()```.
 */
interface SettableCollection extends Collection
{
    public function setData(array $data): void;
}
