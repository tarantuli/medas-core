<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\File;

interface ThumbnailMaker
{
    public function get(File $file, int|null $width, int|null $height): File;
}
