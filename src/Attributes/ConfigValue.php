<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\ConfigOptions\ConfigOptionResolver;

/**
 * Injects the value of a config option into a parameter or property.
 *
 * The configured value is used, or else the option's default. Strings like `'true'`, `'42'` or `'null'` are
 * converted when the parameter's type asks for a `bool`, an `int` or a `float`, or allows `null`. With neither a
 * configured value nor a default, the parameter's own default value is used, or `null` when it allows that.
 * Otherwise resolving fails with `CouldNotResolveParameter`.
 *
 * It can be put on parameters and on properties, so it also works on promoted constructor properties.
 *
 * @assumes `$configOption` is the class of a `ConfigOption` service. Otherwise resolving fails with
 *          `ConfigValueDoesNotImplementOption`.
 * @see ConfigOptionResolver
 */
#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
class ConfigValue
{
    public function __construct(
        public string $configOption,
    )
    {
    }
}
