<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class File
{
    public function __construct(
        public string      $content,
        public string|null $name = null,
    )
    {
    }
}
