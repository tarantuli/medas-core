<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\DataHolder]
readonly class File
{
    public function __construct(
        public string      $content,
        public string|null $name = null,
        public string|null $mimetype = null,
        public string|null $contentHash = null,
    )
    {
    }
}
