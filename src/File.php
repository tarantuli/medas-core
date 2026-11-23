<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A file held in memory: its content, with what's known about it.
 */
#[Attributes\DataHolder]
readonly class File
{
    /**
     * @param string|null $contentHash A hash of the content, when one is known.
     */
    public function __construct(
        public string      $content,
        public string|null $name = null,
        public string|null $mimetype = null,
        public string|null $contentHash = null,
    )
    {
    }
}
