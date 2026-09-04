<?php

declare(strict_types=1);

namespace Medas\Core;

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
