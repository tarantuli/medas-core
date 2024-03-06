<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * The routed request handler manager is responsible for finding and executing a handler for a given HTTP request. It
 * should check the registered implementations of @class(Medas\Core\Interfaces\RoutedRequestHandler) whether they can
 * handle the request by executing ```handles()```.
 *
 * The default implementation is @class(Medas\Routing\HandlerManager).
 */
interface RoutedRequestHandlerManager
{
    public function find(string $method, string $path): RoutedRequestHandler|null;

    public function findByName(string $name): RoutedRequestHandler|null;
}
