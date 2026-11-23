<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A reference to another entity, stored as that entity's ID, or a backed enum, stored as its value.
 *
 * Used for properties typed as an entity class, a class that implements `HasId`, or an enum, when they have no type
 * attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Relation extends BaseType
{
    /**
     * @param string $entity The class of the entity, or of the enum.
     */
    public function __construct(
        public string $entity,
    )
    {
    }
}
