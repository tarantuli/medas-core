<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Finds the @class(Medas\Core\Interfaces\HttpRequestHandler) for an HTTP request, by asking the registered handlers
 * whether they handle it with `handles()`.
 *
 * The default implementation is @class(Medas\Routing\HandlerManager).
 */
interface HttpRequestHandlerManager
{
    /**
     * Returns the handler for the request, or `null` when no handler handles it.
     *
     * @param string $method The HTTP method in capitals, like `'GET'`
     * @param string $path   The path of the request, without the query string
     */
    public function find(string $method, string $path): HttpRequestHandler|null;

    /**
     * Returns the handler with the given name, like the name of a route, or `null` when there's none.
     */
    public function findByName(string $name): HttpRequestHandler|null;
}
