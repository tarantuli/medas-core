<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\Interfaces\DeclaresMaxStringLength;

class DebuggedCircularDependencyFound extends BaseException implements DeclaresMaxStringLength
{
    public function __construct(array $requestStates, string $current, string $source)
    {
        $history = '';

        foreach ($requestStates as $state) {
            $history .= sprintf(
                "  %s  %s   from %s\n",
                $state[2] ? '✓' : '☐',
                $state[0],
                $state[1]
            );
        }

        parent::__construct("triggered by instantiation request for $current from $source\n\n" . $history);
    }

    public function pattern(): string
    {
        return "%s";
    }

    public function maxStringLength(): int
    {
        return 10000;
    }
}
