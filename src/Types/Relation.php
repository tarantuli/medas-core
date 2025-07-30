<?php

declare(strict_types=1);

namespace Medas\Core\Types;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Relation extends BaseType
{
    public function __construct(
        public string $entity,
    )
    {
    }
}
