<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Medas\Core\CaseSensitiveString;

readonly class DebugInformation
{
    public string $message;

    public function __construct(string $pattern, ...$arguments)
    {
        foreach ($arguments as &$argument) {
            try {
                $argument = CaseSensitiveString::fromVariable($argument, true, true)
                    ->truncateToCharLength(1000);
            }
            catch (\Exception) {
                $argument = '�';
            }
        }

        $this->message = vsprintf($pattern, $arguments);
    }
}
