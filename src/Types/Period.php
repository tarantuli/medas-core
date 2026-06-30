<?php

declare(strict_types=1);

namespace Medas\Core\Types;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Period extends Text
{
    public function __construct()
    {
        parent::__construct(3, 20);
    }
}
