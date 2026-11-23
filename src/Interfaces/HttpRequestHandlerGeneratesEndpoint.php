<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An @class(Medas\Core\Interfaces\HttpRequestHandler) that can build the path it handles from arguments, so links to
 * it don't have to be written out by hand.
 *
 * For example, a handler for `/user/{id}` returns `'/user/1'` for `endpoint(['id' => 1])`.
 */
interface HttpRequestHandlerGeneratesEndpoint
{
    /**
     * @param array $arguments The values of the path's parameters, keyed by parameter name. A value only has to
     *                         convert to a string, so a UUID object will do.
     */
    public function endpoint(array $arguments = []): string;
}
