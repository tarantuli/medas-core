<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Psr\EventDispatcher\StoppableEventInterface;

abstract class BasicVote implements StoppableEventInterface
{
    public AllowedAccess $allowedAccess = AllowedAccess::Pending;

    public function isPropagationStopped(): bool
    {
        return $this->allowedAccess !== AllowedAccess::Pending;
    }
}
