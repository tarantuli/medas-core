<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Exceptions\StorageExceptionType;

/**
 * Marks exceptions of a storage driver that say what kind of error occurred, so higher-level packages can react to
 * storage errors without depending on a specific driver.
 *
 * http-request-handler, for example, answers a duplicate key or a foreign key violation with status code 409, and a
 * deadlock, a lock wait timeout or a lost connection with 503.
 *
 * A public property `$exceptionType`, readonly or not, satisfies the `{ get; }` hook.
 */
interface StorageException
{
    public StorageExceptionType $exceptionType { get; }
}
