<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Indicates that a method parameter is required due to interface or abstract method signatures, but not actually used
 * by this particular implementation.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER)]
class RequiredButUnused
{
}
