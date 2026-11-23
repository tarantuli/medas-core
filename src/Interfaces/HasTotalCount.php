<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks objects that hold part of a larger set, like one page of results, and know how big the whole set is.
 *
 * Example:
 *
 * - @class(Medas\RestRequestHandler\Responses\CollectionResponse) holds one page of entities.
 */
interface HasTotalCount
{
    /**
     * The number of items in the whole set, not just in this object.
     */
    public function totalCount(): int;
}
