<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * A @class(Medas\Core\CaseSensitiveString) whose `startsWith()`, `endsWith()`, `contains()` and `equals()` ignore
 * case, and with them `surroundedBy()`, `chopFromStart()` and `chopFromEnd()`.
 *
 * Only ASCII letters are compared without case: `'É'` and `'é'` still differ.
 */
readonly class CaseInsensitiveString extends CaseSensitiveString
{
    public function startsWith(string $needle): bool
    {
        return strncasecmp($this->value, $needle, strlen($needle)) === 0;
    }

    public function endsWith(string $needle): bool
    {
        return $needle === '' || strcasecmp($needle, substr($this->value, -strlen($needle))) === 0;
    }

    public function contains(string $needle): bool
    {
        return stripos($this->value, $needle) !== false;
    }

    public function equals(string $needle): bool
    {
        return strcasecmp($this->value, $needle) === 0;
    }
}
