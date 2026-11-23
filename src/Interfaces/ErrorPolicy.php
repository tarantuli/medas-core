<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Decides what happens with PHP errors like warnings, notices and deprecations: for example, whether they're turned
 * into exceptions. The application chooses one when it creates the `ServiceConfigBuilder`.
 *
 * Examples:
 *
 * - @class(Medas\ServiceManager\ErrorHandling\BasicErrorPolicy), for production, leaves every error to PHP. It's
 *   used when no policy is given.
 * - @class(Medas\ServiceManager\ErrorHandling\AggressiveErrorPolicy), for development, turns every error into an
 *   `ErrorException`.
 *
 * @assumes The service manager creates the policy itself with `new`, during bootstrap, so its constructor can't have
 *          arguments.
 */
interface ErrorPolicy
{
    /**
     * Installs the policy, typically with `set_error_handler()`. It's called once per process, while the service
     * manager starts.
     */
    public function set(): void;
}
