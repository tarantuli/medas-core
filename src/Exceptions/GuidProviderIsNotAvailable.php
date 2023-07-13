<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class GuidProviderIsNotAvailable extends BaseException
{
    public function pattern(): string
    {
        return 'no GuidProvider is provided, but it is needed. Try for instance morphp/medas-ramsey-uuid-bridge';
    }
}
