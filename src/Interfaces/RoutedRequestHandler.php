<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface RoutedRequestHandler
{
    public function handle(string $method, string $path): mixed;
}
