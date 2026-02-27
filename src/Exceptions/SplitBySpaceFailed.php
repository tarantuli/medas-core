<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class SplitBySpaceFailed extends BaseException
{
    public function __construct(string $identifier, string $pregErrorMessage)
    {
        parent::__construct($identifier, $pregErrorMessage);
    }

    public function pattern(): string
    {
        return 'Split by space failed on %s: %s';
    }
}
