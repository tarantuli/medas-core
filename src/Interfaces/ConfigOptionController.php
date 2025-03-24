<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * This controller must return the value of the given ConfigOption using a config manager and the option's default value.
 */
interface ConfigOptionController
{
    public function getValue(ConfigOption $option): mixed;

    public function hasValue(ConfigOption $option): bool;
}
