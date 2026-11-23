<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A @class(Medas\Core\Interfaces\Collection) that tells what has changed since its baseline: the content it had when
 * it was loaded or last stored. In @class(Medas\Core\Collections\GenericCollection), a collection created with
 * content has an empty baseline, so all its items count as additions, as a new entity's collection needs.
 *
 * Every method yields the keys and values concerned. Values are compared strictly, so this works best for
 * collections of objects.
 */
interface ManagedCollection extends SettableCollection
{
    /**
     * The values that weren't in the baseline.
     */
    public function getAdditions(): iterable;

    /**
     * The values of the baseline that aren't in the collection anymore.
     */
    public function getDeletions(): iterable;

    /**
     * The values that were in the baseline too, but under another key.
     */
    public function getMovements(): iterable;

    /**
     * The keys that existed in the baseline but now hold another value.
     */
    public function getModifications(): iterable;
}
