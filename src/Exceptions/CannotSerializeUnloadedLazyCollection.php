<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * Thrown when a lazy collection is serialised before its content has been loaded. Its loader is a closure, which
 * can't be serialised, so the copy would have no way to load the content.
 */
class CannotSerializeUnloadedLazyCollection extends BaseException implements Suggestions
{
    public function __construct(string $class)
    {
        parent::__construct($class);
    }

    public function pattern(): string
    {
        return 'cannot serialize a %s before its content has been loaded';
    }

    public function suggestions(): array
    {
        return [
            'load the content first, for example by calling count() on the collection',
        ];
    }
}
