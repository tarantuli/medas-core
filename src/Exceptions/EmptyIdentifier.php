<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class EmptyIdentifier extends BaseException
{
    public function pattern(): string
    {
        return 'empty identifier';
    }
}
