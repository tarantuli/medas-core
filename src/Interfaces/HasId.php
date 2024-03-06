<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This generic interface marks objects that have an identifier method named ```id()```.
 */
interface HasId
{
    public function id(): mixed;
}
