<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Config options and groups declare configurable values for packages. Their value should be determined by turning
 * group and option names into a dot separated path, and asking the ConfigManager for a value for that path. Options
 * can also declare a default value if none is found this.
 *
 * Packages should implement and use config options were possible, because it makes configurable values findable and
 * therefor listable.
 */
interface ConfigOption
{
    public function group(): ConfigGroup;

    public function name(): string;

    /**
     * A single line describing what this option does. It should start with a capital and not end with a dot
     */
    public function description(): string;

    public function hasDefault(): bool;

    public function default(): mixed;
}
