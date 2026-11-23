<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class UuidProviderIsNotAvailable extends BaseException implements Suggestions
{
    public function pattern(): string
    {
        return 'no UuidProvider is provided, but one is needed';
    }

    public function suggestions(): array
    {
        return [
            'install a package that provides one, like morphp/medas-ramsey-uuid-bridge',
        ];
    }
}
