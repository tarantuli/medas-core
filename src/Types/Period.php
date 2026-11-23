<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A duration, held in a @class(Medas\Core\Period), and stored as an ISO 8601 duration like `'P1DT2H'`, in a text of
 * 3 to 20 characters.
 *
 * Used for properties typed as `Period` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Period extends Text
{
    public function __construct()
    {
        parent::__construct(3, 20);
    }
}
