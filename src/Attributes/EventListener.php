<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

#[\Attribute(\Attribute::TARGET_METHOD)]
class EventListener
{
    /**
     * @param int $priority Higher priority runs earlier. Listeners with equal
     *                      priority keep their discovery order. Defaults to 0.
     */
    public function __construct(
        public int $priority = 0,
    )
    {
    }
}
