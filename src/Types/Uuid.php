<?php

declare(strict_types=1);

namespace Medas\Core\Types;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Uuid extends Binary
{
    public function __construct()
    {
        parent::__construct(16, 16);
    }
}
