<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Classes marked with this interface should not be cached by Cache instances.
 *
 * This can be used as an opt-out on classes that by default are cached. Cache instances are required to check for this
 * interface.
 *
 * Examples:
 *
 * - WithValues and AllEntities from medas/entity-manager are Selectors marked with this interface. Selectors are
 *   cached by default, but these specific implementations should not be.
 */
interface NotCacheable
{
}
