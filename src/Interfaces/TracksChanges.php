<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A collection or object that keeps track of changes to its values or content.
 */
interface TracksChanges
{
    /**
     * Must return true if the content or values of this object have changed since construction or the last call to
     * ```resetChangeTracking()```, false otherwise.
     *
     * @return bool
     */
    public function hasChanged(): bool;

    /**
     * This object must discard all tracked changes up to now and set the current state as its reference.
     *
     * @return void
     */
    public function resetChangeTracking(): void;
}
