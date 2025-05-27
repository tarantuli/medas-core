<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Medas\Core\Attributes\{EventListener, Service};

#[Service]
class DebugInformationGatherer
{
    public array $events = [];

    #[EventListener]
    public function process(DebugInformation $event): void
    {
        $this->events[] = $event->message;
    }
}
