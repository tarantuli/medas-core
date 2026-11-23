<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A UUID, held in a @class(Medas\Core\Interfaces\Uuid), and stored as its 16 bytes.
 *
 * Used for properties typed as `Uuid` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Uuid extends Binary
{
    public function __construct()
    {
        parent::__construct(16, 16);
    }
}
