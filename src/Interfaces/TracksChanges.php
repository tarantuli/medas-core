<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A collection or other object that keeps track of changes to its content, so it can say whether it changed without
 * being compared to a copy.
 *
 * The entity manager asks it whether a property holding it has changed, and storage resets the tracking after loading
 * and after storing it.
 */
interface TracksChanges
{
    /**
     * Whether the content has changed since the object was created, or since the last call to
     * `resetChangeTracking()`.
     */
    public function hasChanged(): bool;

    /**
     * Takes the current content as the state to compare against, forgetting the changes made so far.
     */
    public function resetChangeTracking(): void;
}
