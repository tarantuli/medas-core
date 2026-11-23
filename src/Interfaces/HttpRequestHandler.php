<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Handles the HTTP requests for the method and paths it matches. The
 * @class(Medas\Core\Interfaces\HttpRequestHandlerManager) finds the handler for a request.
 *
 * Between finding the handler and calling `handle()`, http-request-handler dispatches an `AuthorizationVote` with
 * the handler, so vote listeners can allow or deny the request based on it.
 *
 * Example:
 *
 * - @class(Medas\Routing\RouteHandler) handles one method of a controller marked with a `#[Route]` attribute.
 *
 * @see HttpRequestHandlerDefersToMethod
 * @see HttpRequestHandlerGeneratesEndpoint
 */
interface HttpRequestHandler extends DeclaresPriority
{
    /**
     * When several handlers are registered for the same endpoint, the one with the highest priority is used.
     */
    public function priority(): int;

    /**
     * @param string $method The HTTP method in capitals, like `'GET'`
     * @param string $path   The path of the request, without the query string
     */
    public function handles(string $method, string $path): bool;

    /**
     * Handles the request and returns the response. With http-request-handler, that has to be a
     * @class(Medas\HttpRequestHandler\ResponseTypes\Response).
     *
     * @assumes `handles()` returned `true` for the same method and path.
     */
    public function handle(string $method, string $path): mixed;
}
