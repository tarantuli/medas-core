<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An EventListener should contain an eventName to which is reacts, and return the callable which should be executed
 * when an event of the given type is dispatched. The callable should take the event object as its first argument.
 */
interface EventListener
{
    public function eventName(): string;

    public function callable(): callable;
}
