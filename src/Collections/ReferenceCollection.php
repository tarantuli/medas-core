<?php

declare(strict_types=1);

namespace Medas\Core\Collections;

/**
 * The inverse side of a relation: the entities that reference the owning entity through one of their
 * own properties. Unlike owning collections (which extend {@see GenericCollection} / RecordCollection and
 * are populated eagerly), a ReferenceCollection is derived data and is materialised lazily, on first
 * access, via the loader closure it is constructed with.
 *
 * Tying the "reference" role to lazy loading is a deliberate, framework-wide decision: it only asserts
 * "a reference is lazy", not "a lazy collection is a reference" — a lazy owned collection can still
 * extend {@see LazyGenericCollection} directly without touching this class.
 *
 * @template T
 * @extends LazyGenericCollection<T>
 */
class ReferenceCollection extends LazyGenericCollection
{
}
