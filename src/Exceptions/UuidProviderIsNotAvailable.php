<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class UuidProviderIsNotAvailable extends BaseException
{
    public function pattern(): string
    {
        return 'no UuidProvider is provided, but it is needed. Try for instance morphp/medas-ramsey-uuid-bridge';
    }
}
