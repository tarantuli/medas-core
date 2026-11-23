<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\ServiceManager\ErrorHandling\ExceptionHandlerManager;

/**
 * Does something with an exception nobody caught, like logging, mailing or printing it. Packages register their
 * handlers with `ServiceConfigBuilder::addExceptionHandler()`.
 *
 * Every registered handler gets every uncaught exception, also after another one has handled it. Only when none of
 * them handles it is the exception written to `STDERR`, or to the error log.
 *
 * @assumes Handlers are services. They're resolved when the first uncaught exception arrives, not before.
 * @see ExceptionHandlerManager
 */
interface ExceptionHandler
{
    /**
     * Returns whether this handler did something with the exception.
     *
     * @assumes It doesn't throw. The default `ExceptionHandlerManager` reports an exception from a handler and passes
     *          the original on to the other handlers, but this handler's own work is lost.
     */
    public function handleException(\Throwable $exception): bool;
}
