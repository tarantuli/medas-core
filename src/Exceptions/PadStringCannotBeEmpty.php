<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class PadStringCannotBeEmpty extends BaseException
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pattern(): string
    {
        return 'the pad string cannot be empty';
    }
}
