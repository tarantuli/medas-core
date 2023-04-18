<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ServiceManager
{
    /**
     * The return value  is an object of type $type. This is specified in PhpStorm in .phpstorm.meta.php
     */
    public function resolve(string $type): object;
}
