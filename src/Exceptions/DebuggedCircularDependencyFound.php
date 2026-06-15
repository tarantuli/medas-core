<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class DebuggedCircularDependencyFound extends BaseException
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
}
