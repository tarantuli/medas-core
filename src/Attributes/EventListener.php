<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

use Medas\Events\Listeners\ListenerManager;

/**
 * Marks a method of a service as a listener for the events its first parameter accepts.
 *
 * The first parameter must be typed as a class or an interface. With a union type, the method listens to each type in
 * it. A listener also gets the events of subclasses and implementing classes, as PSR-14 requires: one typed with an
 * interface gets every event that implements it.
 *
 * @assumes The method is on a non-abstract class marked with @class(Medas\Core\Attributes\Service). Methods on other
 *          classes aren't found.
 * @cache Which methods listen to which events is cached in the `'default'` cache, so a new or changed listener only
 *        takes effect after the caches are cleared.
 * @see ListenerManager For the order in which listeners run.
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class EventListener
{
    /**
     * @param int $priority Higher priority runs earlier. Among listeners with equal priority, those for the event's
     *                      own class run first, then those for its parent classes and interfaces.
     */
    public function __construct(
        public int $priority = 0,
    )
    {
    }
}
