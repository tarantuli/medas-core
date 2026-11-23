<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * Thrown by the service manager when no service provides a type. The message also lists the types that were being
 * resolved at that moment, outermost first and ending with this one, which shows what needed it.
 */
class ServiceNotFoundByType extends BaseException
{
    public function __construct(string $type, array $activeResolves)
    {
        parent::__construct($type, implode(', ', $activeResolves));
    }

    public function pattern(): string
    {
        return 'service not found with type %s, active resolves: %s';
    }
}
