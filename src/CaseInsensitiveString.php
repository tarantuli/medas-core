<?php

declare(strict_types=1);

namespace Medas\Core;

readonly class CaseInsensitiveString extends CaseSensitiveString
{
    public function startsWith(string $needle): bool
    {
        return strncasecmp($this->string, $needle, strlen($needle)) === 0;
    }

    public function endsWith(string $needle): bool
    {
        return $needle === '' || strcasecmp($needle, substr($this->string, -strlen($needle))) === 0;
    }

    public function contains(string $needle): bool
    {
        return stripos($this->string, $needle) !== false;
    }

    public function equals(string $needle): bool
    {
        return strcasecmp($this->string, $needle) === 0;
    }
}
