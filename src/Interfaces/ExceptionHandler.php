<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ExceptionHandler
{
    /**
     * The handler must return true if it took action to handle the exception.
     */
    public function handleException(\Throwable $exception): bool;
}
