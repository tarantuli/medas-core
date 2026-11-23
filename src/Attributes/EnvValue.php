<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\ObjectInstantiator\ArgumentResolving\EnvValueResolver;

/**
 * Injects the value of the environment variable `$name` into a parameter or property, as `$_ENV` holds it, which is
 * normally a string.
 *
 * It can be put on parameters and on properties, so it also works on promoted constructor properties.
 *
 * @assumes The variable is in `$_ENV` when the argument is resolved. Otherwise resolving fails with
 *          `EnvValueDoesNotExist`, even when the parameter has a default value or allows `null`.
 * @see EnvValueResolver
 */
#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
readonly class EnvValue
{
    public function __construct(
        public string $name,
    )
    {
    }
}
