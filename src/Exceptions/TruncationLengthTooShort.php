<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class TruncationLengthTooShort extends BaseException
{
    public function __construct(int $length)
    {
        parent::__construct($length);
    }

    public function pattern(): string
    {
        return 'cannot truncate to a length of %s: it has to be at least 4';
    }
}
