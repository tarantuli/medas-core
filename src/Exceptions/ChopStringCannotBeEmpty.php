<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class ChopStringCannotBeEmpty extends BaseException
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pattern(): string
    {
        return 'the string to chop cannot be empty';
    }
}
