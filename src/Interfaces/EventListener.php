<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * One listener in the table of an event dispatcher: the event type it's registered for, and what to call.
 *
 * Mark a method with @class(Medas\Core\Attributes\EventListener) to make it a listener; the events package builds
 * these entries from that.
 */
interface EventListener
{
    /**
     * The class or interface the listener is registered for. It also applies to subclasses and implementing classes.
     */
    public function eventName(): string;

    /**
     * Returns what to call with the event as its only argument.
     */
    public function callable(): callable;

    /**
     * Listeners with a higher priority run earlier.
     */
    public function priority(): int;
}
