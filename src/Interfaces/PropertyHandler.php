<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Converts the value of one property for storage and back, for a property marked with
 * @class(Medas\Core\Attributes\Handler). Implementations are services.
 *
 * Example:
 *
 * - @class(Medas\EntityManager\Properties\SerializingHandler) stores any value as text, with PHP's `serialize()`.
 */
interface PropertyHandler
{
    /**
     * The type of the converted value, so storage knows how to store it.
     */
    public function type(): Type;

    public function serialize(mixed $value): mixed;

    /**
     * @param mixed $value What `serialize()` returned
     */
    public function unserialize(mixed $value): mixed;
}
