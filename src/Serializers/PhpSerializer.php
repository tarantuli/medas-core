<?php

declare(strict_types=1);

namespace Medas\Core\Serializers;

use Medas\Core\Interfaces\{StringSerializer, Type};

/**
 * A string serializer that uses PHP's own `serialize()` and `unserialize()`. @class(Medas\Cache\FileSystemCache) uses
 * it by default.
 *
 * @assumes Whatever is unserialized was serialized by the application itself, like a cache file it wrote. Objects of
 *          every class are restored, so untrusted data could create objects whose `__wakeup()`, `__unserialize()` or
 *          `__destruct()` methods then run.
 */
readonly class PhpSerializer implements StringSerializer
{
    private ClosureFinder $closureFinder;

    public function __construct()
    {
        $this->closureFinder = new ClosureFinder();
    }

    /**
     * @throws \Exception When PHP can't serialize the value, with PHP's exception as the previous one. For a closure,
     *                    the message gives the path to the first closure @class(Medas\Core\Serializers\ClosureFinder)
     *                    finds. When the closure only shows up through `__serialize()` or `__sleep()`, the finder
     *                    misses it, and the message only gives the type of the value. For anything else, the message
     *                    starts with the type of the value.
     */
    public function serialize(mixed $value): string
    {
        try {
            return serialize($value);
        }
        catch (\Throwable $e) {
            if (str_contains($e->getMessage(), 'Serialization of \'Closure\'')) {
                $pathToClosure = $this->closureFinder->search($value);

                // The finder misses closures that only show up through __serialize() or __sleep()
                throw new \Exception(
                    $pathToClosure !== null
                        ? 'found a closure at ' . $pathToClosure
                        : get_debug_type($value) . ': contains a closure that couldn\'t be located',
                    $e->getCode(),
                    $e
                );
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

    /**
     * Restores a value from a string made by `serialize()`. `$type` is ignored.
     *
     * @return mixed `false` when the string can't be unserialized, as PHP's `unserialize()` returns, along with its
     *               warning.
     *
     * @throws \TypeError When `$value` isn't a string.
     */
    public function unserialize(mixed $value, Type|null $type = null): mixed
    {
        // Allow any class to be unserialized
        return unserialize($value);
    }
}
