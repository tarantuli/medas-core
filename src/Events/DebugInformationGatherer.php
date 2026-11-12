<?php

declare(strict_types=1);

namespace Medas\Core\Events;

use Medas\Core\{
    Attributes\ConfigValue,
    Attributes\EventListener,
    Attributes\Service,
    ConfigOptions\DebugInformationMaxMessages,
    ConfigOptions\DebugInformationPruneCount
};

/**
 * Collects the messages of all `DebugInformation` events, so error reports can show what happened before an error.
 * `ExceptionCompiler` in error-reporting, for example, adds them to its reports.
 *
 * `Medas\Events\EventDispatcher` only passes `DebugInformation` events on in dev mode, so elsewhere the list stays
 * empty.
 *
 * @state Keeps the messages for the lifetime of the process. Once `core.debug-information-max-messages` messages are
 *        kept, the oldest `core.debug-information-prune-count` are dropped before a new one is added, so long-running
 *        workers don't keep growing the list, and dropping doesn't happen for every new message.
 * @see DebugInformation
 */
#[Service]
class DebugInformationGatherer
{
    /** @var string[] */
    public array $events = [];

    public function __construct(
        /** The number of messages at which the oldest ones are dropped. */
        #[ConfigValue(DebugInformationMaxMessages::class)]
        private readonly int $maxMessages = 500,

        /** How many of the oldest messages are dropped at once. */
        #[ConfigValue(DebugInformationPruneCount::class)]
        private readonly int $pruneCount = 50,
    )
    {
    }

    #[EventListener]
    public function process(DebugInformation $event): void
    {
        if (count($this->events) >= $this->maxMessages) {
            // Always drop at least one, or the list would grow past the maximum
            array_splice($this->events, 0, max(1, $this->pruneCount));
        }

        $this->events[] = $event->message;
    }
}
