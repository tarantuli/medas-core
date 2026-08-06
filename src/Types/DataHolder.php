<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A property typed as a #[DataHolder]-annotated value object. Serialized to an
 * array (see ObjectToArraySerializer) and, in string-only backends like
 * pdo-storage, stored as a JSON varchar. Carries the value object's class name
 * so it can be reconstructed on the way back.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class DataHolder extends Text
{
    public function __construct(
        public string $className,
    )
    {
        parent::__construct(maxLength: Binary::MAX_2_BYTE_LENGTH);
    }
}
