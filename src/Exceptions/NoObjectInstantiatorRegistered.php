<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class NoObjectInstantiatorRegistered extends BaseException implements Suggestions
{
    public function pattern(): string
    {
        return 'no object instantiator has been registered yet';
    }

    public function suggestions(): array
    {
        return [
            'create a new Medas\Core\Interfaces\ObjectInstantiator, and register it with Medas\Core\GlobalRepository\setObjectInstantiator()',
        ];
    }
}
