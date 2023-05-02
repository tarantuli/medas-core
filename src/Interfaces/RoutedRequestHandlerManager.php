<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface RoutedRequestHandlerManager
{
    public function find(string $method, string $path): RoutedRequestHandler|null;

    public function findByName(string $name): RoutedRequestHandler|null;
}
