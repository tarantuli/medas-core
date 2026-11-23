<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A value object whose class is marked with @class(Medas\Core\Attributes\DataHolder). It's converted to an array to
 * be stored, and back into an object of `$className` when it's loaded. Backends that only store strings, like
 * pdo-storage, keep the array as JSON, in a text of at most 65535 characters.
 *
 * Used for properties typed as such a class that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DataHolder extends Text
{
    /**
     * @param string $className The class of the value object.
     */
    public function __construct(
        public string $className,
    )
    {
        parent::__construct(maxLength: Binary::MAX_2_BYTE_LENGTH);
    }
}
