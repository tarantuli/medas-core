<?php

declare(strict_types=1);

namespace Medas\Core;

class File
{
    public string $content;
    public string|null $name = null;
    public string|null $mimetype = null;
    public string|null $contentHash = null;
}
