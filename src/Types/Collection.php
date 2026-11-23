<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A collection of entities, kept apart from the entity that holds it, like in a join table.
 *
 * Used for properties typed as a collection class marked with `#[EntityCollection]`, which has to implement
 * `ManagedCollection`.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Collection extends BaseType
{
    /**
     * @param string $collectionType The class of the collection, created without arguments when it's loaded.
     * @param string $contentType    The class of the items.
     */
    public function __construct(
        public string $collectionType,
        public string $contentType,
    )
    {
    }
}
