<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks objects that don't load their data when they're created, but only when it's first needed.
 *
 * Storage uses it for collections: instead of loading the items of a to-many relation along with the entity, it gives
 * the collection a loader, which only runs when the collection is read.
 */
interface IsLazyLoaded
{
    /**
     * Sets what loads the data. The object calls it once, when the data is first needed, and uses what it returns.
     * The loaded data is the state that change tracking compares against.
     */
    public function setLoader(callable $loader): void;
}
