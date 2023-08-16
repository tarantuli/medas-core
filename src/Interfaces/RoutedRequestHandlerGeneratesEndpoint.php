<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * RoutedRequestHandler implementations that also implement this interface should return the endpoint that they would
 * handle with the given arguments.
 *
 * Example, if a handler would process "/user/1" as a route with parameter id 1, then endpoint(["id" => 1]) should
 * return "/user/1".
 */
interface RoutedRequestHandlerGeneratesEndpoint
{
    public function endpoint(array $arguments = []): string;
}
