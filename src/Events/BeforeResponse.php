<?php

declare(strict_types=1);

namespace Medas\Core\Events;

/**
 * Dispatched by @class(Medas\HttpRequestHandler\HttpRequestHandler) once a request has been handled, before the
 * response is written, so listeners can do last work such as writing changes to storage.
 * @class(Medas\EntityManager\EntityManager) flushes on it.
 *
 * It isn't dispatched when handling the request throws, or outside HTTP requests, such as in console commands.
 */
class BeforeResponse
{
}
