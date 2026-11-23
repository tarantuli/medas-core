<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Returns the value of a @class(Medas\Core\Interfaces\ConfigOption): the value the
 * @class(Medas\Core\Interfaces\ConfigManager) has for its path, or else its default.
 *
 * A configured value is checked when the option implements @class(Medas\Core\Interfaces\Validator), and converted
 * with `unserialize()` when it implements @class(Medas\Core\Interfaces\Serializer). The default is used as it is.
 *
 * The default implementation is @class(Medas\ConfigOptions\OptionController).
 */
interface ConfigOptionController
{
    /**
     * Throws when the option has neither a configured value nor a default, or when the configured value doesn't pass
     * the option's validation. Which exceptions it throws depends on the implementation.
     */
    public function getValue(ConfigOption $option): mixed;

    /**
     * Whether `getValue()` has a value to return: a configured value or a default.
     */
    public function hasValue(ConfigOption $option): bool;
}
