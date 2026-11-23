<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * The PSR-14 event dispatcher, with a way to skip building an event that nobody listens to. The global function
 * `dispatch()` reaches it.
 *
 * Listeners apply to an event when they're typed with its class, a parent class or an interface it implements. They
 * run one after another, in order of priority. For an event that implements `StoppableEventInterface`, the rest are
 * skipped once `isPropagationStopped()` returns `true`.
 *
 * The default implementation is @class(Medas\Events\EventDispatcher).
 */
interface EventDispatcher extends EventDispatcherInterface
{
    /**
     * Returns `$event` itself, after the listeners have run, so callers can read what they changed. PhpStorm knows
     * the return type from `.phpstorm.meta.php`.
     */
    public function dispatch(object $event): object;

    /**
     * Calls `$callable` to create the event only when at least one listener applies to `$eventType`, and then
     * dispatches it. Use it for events that are expensive to build.
     *
     * Returns the event after the listeners have run, or `null` when there are no listeners, and so no event was
     * created. PhpStorm knows the return type from `.phpstorm.meta.php`.
     *
     * @assumes `$callable` returns an instance of `$eventType`.
     */
    public function lazyDispatch(string $eventType, callable $callable): object|null;
}
