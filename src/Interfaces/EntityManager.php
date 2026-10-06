<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface EntityManager
{
    /**
     * $trackChanges: false skips change-diffing for this entity entirely -- use it for a fetch
     * that's known to be read-only (an existence check, a lookup you won't mutate). Ignored on a
     * cache hit for an entity that is already being tracked (tracking is one-way: it never turns
     * back off once started); on a cache hit for a currently-untracked entity, passing true here
     * starts tracking it from that point forward.
     */
    public function get(string $className, mixed $id, bool $trackChanges = true): object;

    public function create(string $className, array $values = []): object;

    public function persist(object ...$entities): void;

    public function delete(object $entity): void;

    public function flush(): void;

    public function clear(): void;
}
