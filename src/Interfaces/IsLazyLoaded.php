<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Objects that implement this interface should not load their data on instantiation, but only when it is needed.
 * They should load it by executing the closure provided using ```setLoader()```.
 */
interface IsLazyLoaded
{
    public function setLoader(callable $loader): void;
}
