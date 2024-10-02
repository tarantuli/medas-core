<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * HttpRequestHandler implementations that also implement this interface should return the method they call to actually
 * handle the request.
 *
 */
interface HttpRequestHandlerDefersToMethod
{
    public function handlerMethod(): \ReflectionMethod;
}
