<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

enum StorageExceptionType
{
    /** Unique constraint violation — a record with these values already exists. */
    case DuplicateKey;

    /** Foreign key constraint violation — referenced record does not exist, or parent record still has children. */
    case ForeignKeyViolation;

    /** The storage engine detected a deadlock and rolled back this transaction so the other could proceed. */
    case DeadlockDetected;

    /** A lock could not be acquired within the configured wait timeout. */
    case LockWaitTimeout;

    /** The storage connection was lost mid-request. */
    case ConnectionLost;

    /** The exception type could not be determined from the driver-specific error. */
    case Unknown;
}
