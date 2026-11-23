<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Declares a configurable value of a package, so it can be found, listed and documented. Packages should use config
 * options for every configurable value.
 *
 * The option's path is made of the names of its groups, top-level group first, followed by its own name, separated by
 * dots: `'core.url-reader-transfer-timeout'`. The @class(Medas\Core\Interfaces\ConfigOptionController) asks the
 * @class(Medas\Core\Interfaces\ConfigManager) for that path, and uses the default when nothing is configured.
 *
 * An option can also implement @class(Medas\Core\Interfaces\Validator), to have a configured value checked, and
 * @class(Medas\Core\Interfaces\Serializer), to have it converted. Neither is applied to the default.
 *
 * Inject the value into a service with @class(Medas\Core\Attributes\ConfigValue).
 */
interface ConfigOption
{
    public function group(): ConfigGroup;

    /**
     * This option's part of the path, without dots.
     */
    public function name(): string;

    /**
     * A single line describing what this option does. It should start with a capital and not end with a dot.
     */
    public function description(): string;

    public function hasDefault(): bool;

    /**
     * The value to use when nothing is configured. Only asked for when `hasDefault()` returns `true`.
     */
    public function default(): mixed;
}
