<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

use Medas\Core\Lists\SortByPriority;

/**
 * Marks objects that can be put in order by a number, like parameter resolvers, packages and request handlers.
 *
 * Which order that is depends on the code that sorts them: most of it puts the highest priority first, but
 * @class(Medas\Core\CachedImplementorList) can sort either way. The interfaces that extend this one say what their
 * priority means.
 *
 * @see SortByPriority
 */
interface DeclaresPriority
{
    public function priority(): int;
}
