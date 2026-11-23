<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks a parameter that's required by the signature of an interface or abstract method, but not used by this
 * particular implementation, so readers and tools that look for unused parameters know it's left out on purpose.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER)]
class RequiredButUnused
{
}
