<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A generic interface that combines \ArrayAccess, \Iterator and \Countable.
 *
 * Examples:
 *
 * - GenericCollection from medas/core.
 *
 * - LazyGenericCollection from medas/core is a collection that only calls its fetcher when data is actually read.
 */
interface Collection extends \ArrayAccess, \Iterator, \Countable
{
}
