<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Config managers should gather and cache configuration values from the environment.
 *
 * Example:
 *
 * - @class(Medas\ConfigManager\ConfigManager) reads input from .yaml files in a given directory. It replaces values
 * that look like "$env(...)" with values from .env files in a given directory and the ```$_ENV``` variable. It caches
 * all read values.
 */
interface ConfigManager
{
    /** @param string $path A dot separated name */
    public function hasValue(string $path): bool;

    /** @param string $path A dot separated name */
    public function getValue(string $path): mixed;

    /**
     * This method should only be used during testing
     *
     * @param string $path A dot separated name
     */
    public function setValue(string $path, mixed $value): void;
}
