<?php

declare(strict_types=1);

namespace Medas\Core\Types;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Integer extends BaseType
{
    const int UNSIGNED_1_BYTE_MAX = 255;
    const int UNSIGNED_2_BYTE_MAX = 65535;
    const int UNSIGNED_3_BYTE_MAX = 16777215;
    const int UNSIGNED_4_BYTE_MAX = 4294967295;
    const float UNSIGNED_8_BYTE_MAX = 18446744073709551615;
    const int SIGNED_1_BYTE_MIN = -128;
    const int SIGNED_1_BYTE_MAX = 127;
    const int SIGNED_2_BYTE_MIN = -32768;
    const int SIGNED_2_BYTE_MAX = 32767;
    const int SIGNED_3_BYTE_MIN = -8388608;
    const int SIGNED_3_BYTE_MAX = 8388607;
    const int SIGNED_4_BYTE_MIN = -2147483648;
    const int SIGNED_4_BYTE_MAX = 2147483647;
    const int SIGNED_8_BYTE_MIN = -9223372036854775808;
    const int SIGNED_8_BYTE_MAX = 9223372036854775807;

    public function __construct(
        public int      $minValue = 0,
        public int|null $maxValue = null,
    )
    {
    }
}
