<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class InvalidIso8601Duration extends BaseException
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    }

    public function pattern(): string
    {
        return 'invalid ISO 8601 duration string: %s';
    }
}
