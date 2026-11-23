<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * Thrown by @class(Medas\Core\Collections\LazyGenericCollection) when its content is used, but it has neither a loader
 * nor data set with `setData()`.
 */
class NoInitializerHasBeenSet extends BaseException
{
    public function pattern(): string
    {
        return 'no initializer has been set';
    }
}
