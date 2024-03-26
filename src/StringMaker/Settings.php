<?php

declare(strict_types=1);

namespace Medas\Core\StringMaker;

class Settings
{
    public function __construct(
        public bool $quotesOnlyAroundWhitespace = false,
        public bool $forceUtf8 = false,
    )
    {
    }
}
