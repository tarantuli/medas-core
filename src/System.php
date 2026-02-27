<?php

declare(strict_types=1);

namespace Medas\Core;

class System
{
    public static function isFunctionAvailable(string $name): bool
    {
        static $disabled = null;

        if ($disabled === null) {
            $disabled = array_map('trim', explode(',', ini_get('disable_functions')));
        }

        return is_callable($name) && !in_array($name, $disabled, true);
    }
}
