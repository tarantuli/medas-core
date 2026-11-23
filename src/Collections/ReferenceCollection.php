<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

/**
 * The inverse side of a relation: the entities that reference the owning entity through one of their own properties.
 * Unlike owning collections, which extend @class(Medas\Core\Collections\GenericCollection) or `RecordCollection` and
 * are filled right away, a `ReferenceCollection` is derived data, loaded on first access by its loader.
 *
 * Tying the reference role to lazy loading is a deliberate, framework-wide decision: it only says that a reference is
 * lazy, not that a lazy collection is a reference. A lazy owned collection can still extend
 * @class(Medas\Core\Collections\LazyGenericCollection) directly, without this class.
 *
 * @template T
 * @extends LazyGenericCollection<T>
 */
class ReferenceCollection extends LazyGenericCollection
{
}
