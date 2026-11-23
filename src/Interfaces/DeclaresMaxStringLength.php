<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Lets an exception extending @class(Medas\Core\Exceptions\BaseException) limit how long the values in its message
 * get: longer values are cut off.
 */
interface DeclaresMaxStringLength
{
    /**
     * In characters, for each value put into the message. It has to be at least 4; with less, every value is written
     * as `�`.
     */
    public function maxStringLength(): int;
}
