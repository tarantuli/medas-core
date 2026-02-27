<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class FailedToReadContent extends BaseException
{
    public function __construct(string $path, string $errorMessage)
    {
        parent::__construct($path, $errorMessage);
    }

    public function pattern(): string
    {
        return 'failed to read content of %s: %s';
    }
}
