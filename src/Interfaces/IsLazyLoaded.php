<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface IsLazyLoaded
{
    public function setLoader(\Closure $loader): void;
}
