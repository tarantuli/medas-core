<?php

declare(strict_types=1);

namespace Medas\Core\Types;

use Medas\Core\Attributes\ValueValidator;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class EmailAddress extends Text
{
    #[ValueValidator]
    public function validate(string $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
