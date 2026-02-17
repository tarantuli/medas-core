<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class NoInitializerHasBeenSet extends BaseException
{
    public function pattern(): string
    {
        return 'no initializer has been set';
    }
}
