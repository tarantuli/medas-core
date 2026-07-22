<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class ServiceNotFoundByType extends BaseException
{
    public function __construct(string $type, array $activeResolves)
    {
        parent::__construct($type, implode(', ', $activeResolves));
    }

    public function pattern(): string
    {
        return 'service not found with type %s, active resolves: %s';
    }
}
