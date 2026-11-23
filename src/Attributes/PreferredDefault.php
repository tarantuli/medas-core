<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\ObjectInstantiator\ArgumentResolving\PreferredDefaultFinder;

/**
 * Chooses the service that's injected into a parameter or property whose type has several implementations: the
 * service that provides `$className`.
 *
 * It can be put on parameters and on properties, so it also works on promoted constructor properties. When no service
 * provides `$className`, the parameter is resolved as if the attribute weren't there, which normally means by its type.
 *
 * @assumes `$className` fits the type of the parameter. That isn't checked; a mismatch ends in a `TypeError` when the
 *          arguments are passed.
 * @notFor Choosing an implementation for every parameter of a type at once; use
 *         `ServiceConfigBuilder::addTypeBinding()` for that.
 * @see PreferredDefaultFinder
 */
#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
readonly class PreferredDefault
{
    public function __construct(
        public string $className,
    )
    {
    }
}
