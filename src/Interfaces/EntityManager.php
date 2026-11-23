<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Loads, creates and stores entities. It keeps one instance per entity, so getting the same entity twice returns the
 * same object, and it writes changes to storage only when `flush()` is called.
 *
 * The default implementation is @class(Medas\EntityManager\EntityManager).
 *
 * @state Keeps every entity it loaded or was given until `clear()` is called. In a long-running worker, call
 *        `clear()` between jobs, so the entities of one job aren't reused in the next.
 */
interface EntityManager
{
    /**
     * Returns the entity of `$className` with `$id`, loading it from storage the first time. The return value is an
     * object of type `$className`.
     *
     * @param bool $trackChanges `false` skips looking for changes to this entity at `flush()` time. Use it for an
     *                           entity that's only read, like for an existence check. Tracking can't be switched off
     *                           once it has started: for an entity that's already tracked, `false` is ignored. For an
     *                           entity that isn't tracked yet, `true` starts tracking it from now on, so changes made
     *                           before this call aren't stored.
     */
    public function get(string $className, mixed $id, bool $trackChanges = true): object;

    /**
     * Returns a new entity of `$className`, with its properties set from `$values`. The return value is an object of
     * type `$className`.
     *
     * Whether it's persisted right away depends on the implementation's settings; call `persist()` to be sure.
     */
    public function create(string $className, array $values = []): object;

    /**
     * Has new entities stored at the next `flush()`. Entities the manager already knows are left as they are.
     */
    public function persist(object ...$entities): void;

    /**
     * Has the entity deleted from storage at the next `flush()`.
     */
    public function delete(object $entity): void;

    /**
     * Writes all new, changed and deleted entities to storage.
     */
    public function flush(): void;

    /**
     * Forgets every entity, without writing anything, so later calls load them from storage again. Changes that
     * haven't been flushed are lost.
     */
    public function clear(): void;
}
