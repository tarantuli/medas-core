<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This generic interface marks objects that have a name returning method named ```name()```.
 */
interface HasName
{
    public function name(): string;
}
