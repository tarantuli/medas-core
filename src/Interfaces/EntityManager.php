<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface EntityManager
{
    public function get(string $className, mixed $id): object;

    public function create(string $className, array $values = []): object;

    public function persist(object ...$entities): void;

    public function delete(object $entity): void;

    public function flush(): void;

    public function clear(): void;
}
