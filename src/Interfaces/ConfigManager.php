<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Supplies configuration values by their dot-separated path, like `'core.url-reader-transfer-timeout'`.
 *
 * Packages normally don't ask it directly: they declare a @class(Medas\Core\Interfaces\ConfigOption) and read it
 * through the @class(Medas\Core\Interfaces\ConfigOptionController), so the value is validated and has a default.
 *
 * Example:
 *
 * - @class(Medas\ConfigManager\ConfigManager) reads `.yaml` files from the directories it's given. It replaces values
 *   like `'$env(NAME)'` with values from `.env` files and `$_ENV`, and caches all values it reads.
 */
interface ConfigManager
{
    /** @param string $path A dot-separated name */
    public function hasValue(string $path): bool;

    /**
     * Returns the configured value. What happens for a path without a value depends on the implementation, so check
     * with `hasValue()` first.
     *
     * @param string $path A dot-separated name
     */
    public function getValue(string $path): mixed;

    /**
     * Only for tests: sets a value for the rest of the process.
     *
     * @param string $path A dot-separated name
     */
    public function setValue(string $path, mixed $value): void;
}
