<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ExceptionHandler
{
    public function handleException(\Throwable $exception): void;
}
