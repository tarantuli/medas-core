<?php

declare(strict_types=1);

namespace Medas\Core\Types;

use Medas\Core\Attributes\ValueValidator;

/**
 * A text that has to be an email address, as PHP's `FILTER_VALIDATE_EMAIL` checks it.
 *
 * @see ValueValidator
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class EmailAddress extends Text
{
    /**
     * Returns `true` when `$value` is a valid email address.
     */
    #[ValueValidator]
    public function validate(string $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
