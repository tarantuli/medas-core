<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Medas\Core\StringMaker;

readonly class DebugInformation
{
    public string $message;

    public function __construct(string $pattern, ...$arguments)
    {
        $this->message = StringMaker::instance()->fromPattern($pattern, $arguments);
    }
}
