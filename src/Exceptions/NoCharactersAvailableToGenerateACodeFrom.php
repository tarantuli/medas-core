<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class NoCharactersAvailableToGenerateACodeFrom extends BaseException
{
    public function __construct()
    {
        parent::__construct();
    }

    public function pattern(): string
    {
        return 'No characters available to generate a code from.';
    }
}
