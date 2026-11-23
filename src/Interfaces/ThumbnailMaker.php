<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\File;

/**
 * Makes a smaller version of an image.
 *
 * Examples:
 *
 * - @class(Medas\ImageManager\ResizedThumbnailMaker) fits the whole image within the size, on a transparent
 *   background.
 * - @class(Medas\ImageManager\CroppedThumbnailMaker) fills the size, cutting off the edges that don't fit.
 *
 * Both return an image that already fits within the size as it is, without enlarging it.
 */
interface ThumbnailMaker
{
    /**
     * Returns a thumbnail of the image in `$file`. With only one of `$width` and `$height`, the other follows from
     * the image's aspect ratio. With neither, the file is returned as it is.
     *
     * @param int|null $width  In pixels
     * @param int|null $height In pixels
     */
    public function get(File $file, int|null $width, int|null $height): File;
}
