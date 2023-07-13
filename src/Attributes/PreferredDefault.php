<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Allow both to allow the attribute to be assigned to parameters in constructors
 * with property promotion.
 */
#[\Attribute(\Attribute::TARGET_PARAMETER | \Attribute::TARGET_PROPERTY)]
class PreferredDefault
{
    public function __construct(
        public readonly string $className,
    )
    {
    }
}
