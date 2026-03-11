<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Interfaces\{Serializer, Type};

/**
 * A Serializer implementation that defers to PHP's internal serialize() and unserialize() methods.
 */
readonly class PhpSerializer implements Serializer
{
    private ClosureFinder $closureFinder;

    public function __construct()
    {
        $this->closureFinder = new ClosureFinder();
    }

    public function serialize(mixed $value): string
    {
        try {
            return serialize($value);
        }
        catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'Serialization of \'Closure\'')) {
                $pathToClosure = $this->closureFinder->search($value);

                throw new \Exception('found a closure at ' . $pathToClosure, $e->getCode(), $e);
            }
            else {
                throw new \Exception(
                    get_debug_type($value) . ': ' . $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
        }
    }

    public function unserialize(mixed $value, Type|null $type = null): mixed
    {
        // Allow any class to be unserialized
        return unserialize($value);
    }
}
