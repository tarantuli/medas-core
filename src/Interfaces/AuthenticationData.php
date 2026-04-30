<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface AuthenticationData
{
    public function getUserId(): mixed;
}
