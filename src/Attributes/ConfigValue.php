<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/*
 * Allow both targets to allow the attribute to be assigned to parameters in constructors with property promotion.
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
