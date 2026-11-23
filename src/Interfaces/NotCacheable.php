<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks values that a @class(Medas\Core\Interfaces\Cache) mustn't store, as an opt-out for classes that are cached by
 * default. Every cache is required to check for it.
 *
 * Only the value itself is checked, not the objects it contains.
 *
 * Examples:
 *
 * - @class(Medas\EntityManager\Selector\Selectors\WithValues) and
 *   @class(Medas\EntityManager\Selector\Selectors\AllEntities) are selectors marked with this interface. Selectors are
 *   cached by default, but these specific ones shouldn't be.
 */
interface NotCacheable
{
}
