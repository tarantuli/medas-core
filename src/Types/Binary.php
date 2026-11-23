<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * Bytes with a length between `$minLength` and `$maxLength`, 255 at most by default.
 *
 * The storage backend picks a column that fits the lengths. pdo-mysql-migration-builder, for example, makes a
 * `binary` column when both lengths are equal and at most 255, a `varbinary` when they differ, and a `blob` type above
 * 255. The constants are the largest lengths that fit a length prefix of 1 to 4 bytes.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Binary extends BaseType
{
    const int MAX_1_BYTE_LENGTH = 255;
    const int MAX_2_BYTE_LENGTH = 65535;
    const int MAX_3_BYTE_LENGTH = 16777215;
    const int MAX_4_BYTE_LENGTH = 4294967295;

    /**
     * @param int|null $length Sets both `$minLength` and `$maxLength`, for values that always have the same length.
     */
    public function __construct(
        public int $minLength = 0,
        public int $maxLength = self::MAX_1_BYTE_LENGTH,
        int|null   $length = null
    )
    {
        if ($length !== null) {
            $this->minLength = $this->maxLength = $length;
        }
    }
}
