<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class RegexReplaceFailed extends BaseException
{
    public function __construct(string $string, string $regexPattern, string $replacement, string $pregErrorMessage)
    {
        parent::__construct($regexPattern, $replacement, $string, $pregErrorMessage);
    }

    public function pattern(): string
    {
        return 'failed to replace %s with %s in %s: %s';
    }
}
