<?php

declare(strict_types=1);

namespace Medas\Core;

class System
{
    public static function isFunctionAvailable(string $name): bool
    {
        return is_callable($name)
            && !str_contains(ini_get('disable_functions'), $name);
    }
}
