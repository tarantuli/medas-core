<?php

declare(strict_types=1);

namespace Medas\Core\Lists;

/**
 * How @class(Medas\Core\CachedImplementorList) orders the services it finds, by the priority they declare with
 * @class(Medas\Core\Interfaces\DeclaresPriority).
 */
enum SortByPriority
{
    /** In the order the implementor finder returns them, which isn't guaranteed. */
    case No;

    /** Highest priority first. */
    case HighToLow;

    /** Lowest priority first. */
    case LowToHigh;
}
