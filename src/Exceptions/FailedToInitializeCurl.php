<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class FailedToInitializeCurl extends BaseException
{
    public function pattern(): string
    {
        return 'failed to initialize cURL';
    }
}
