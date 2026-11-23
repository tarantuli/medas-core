<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Checks on the PHP environment.
 */
class System
{
    /**
     * Returns `true` when the function exists and isn't turned off with the `disable_functions` setting.
     */
    public static function isFunctionAvailable(string $name): bool
    {
        static $disabled = null;

        if ($disabled === null) {
            $disabled = array_map('trim', explode(',', ini_get('disable_functions')));
        }

        return is_callable($name) && !in_array($name, $disabled, true);
    }
}
