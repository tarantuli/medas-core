<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class ServiceNotFoundByType extends BaseException
{
    public function __construct(string $type)
    {
        parent::__construct($type);
    }

    public function pattern(): string
    {
        return 'service not found with type %s';
    }
}
