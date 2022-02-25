<?php

declare(strict_types=1);

namespace Medas\Core;

interface ThumbnailMaker
{
    public function get(FileEntity $file, int|null $width, int|null $height): FileEntity;
}
