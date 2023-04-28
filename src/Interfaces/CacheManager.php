<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface CacheManager
{
    public function get(string $name = 'default'): Cache;

    public function register(Cache $cache, string $name = 'default'): void;

    public function clearAll(): void;
}
