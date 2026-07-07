<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This generic interface marks objects that have a total record count, which can be fetched using ```totalCount()```.
 */
interface HasTotalCount
{
    public function totalCount(): int;
}
