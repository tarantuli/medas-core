<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Exceptions\StorageExceptionType;

/**
 * Marker interface for storage-layer exceptions that carry a typed classification.
 * Drivers implement this on their concrete exception classes so that higher-level
 * packages (e.g., entity-manager) can react to storage errors without depending on
 * any specific storage implementation.
 *
 * The { get; } hook requires PHP 8.4 and is satisfied by any public or public readonly
 * property named $exceptionType in the implementing class.
 */
interface StorageException
{
    public StorageExceptionType $exceptionType{get;

    }
}
