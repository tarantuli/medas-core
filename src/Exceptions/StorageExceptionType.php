<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * The kind of error a @class(Medas\Core\Interfaces\StorageException) reports. Storage drivers translate their own
 * error codes into these cases, so other packages can react to them without knowing the driver.
 */
enum StorageExceptionType
{
    /** A unique constraint was violated: a record with these values already exists. */
    case DuplicateKey;

    /**
     * A foreign key constraint was violated: the referenced record doesn't exist, or a record that's referenced still
     * has records referring to it.
     */
    case ForeignKeyViolation;

    /** The storage engine found a deadlock, and rolled back this transaction so the other one could go on. */
    case DeadlockDetected;

    /** A lock couldn't be acquired within the configured waiting time. */
    case LockWaitTimeout;

    /** The connection to the storage was lost during the request. */
    case ConnectionLost;

    /** The driver couldn't tell which kind of error its own error is. */
    case Unknown;
}
