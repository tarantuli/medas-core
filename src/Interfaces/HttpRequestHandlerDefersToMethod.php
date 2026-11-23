<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An @class(Medas\Core\Interfaces\HttpRequestHandler) that handles requests by calling a method, like a controller
 * method. Code that decides about a request can then look at that method and its class, for example at their
 * attributes.
 *
 * The authorisation vote handlers of http-request-handler use it: a method or class marked with `#[PublicResource]`
 * or `#[AnyUser]` is allowed without further checks.
 */
interface HttpRequestHandlerDefersToMethod
{
    /**
     * The method that handles the request.
     */
    public function handlerMethod(): \ReflectionMethod;
}
