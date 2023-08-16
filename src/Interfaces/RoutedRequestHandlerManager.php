<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The routed request handler manager is responsible for finding and executing a handler for a given HTTP request. It
 * should check the registered implementations of RoutedRequestHandler whether they can handle the request by executing
 * handles().
 *
 * The default implementation is found in medas/routing.
 */
interface RoutedRequestHandlerManager
{
    public function find(string $method, string $path): RoutedRequestHandler|null;

    public function findByName(string $name): RoutedRequestHandler|null;
}
