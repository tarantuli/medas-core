<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class NoServiceManagerRegistered extends BaseException implements Suggestions
{
    public function pattern(): string
    {
        return 'no service manager has been registered yet';
    }

    public function suggestions(): array
    {
        return [
            'create a new Medas\Core\Interfaces\ServiceManager, and register it with Medas\Core\GlobalRepository\setServiceManager()',
        ];
    }
}
