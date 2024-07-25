<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A Bearer token validator must take a token from an Authorization header value "Bearer <token>" and return the
 * associated user object if it's valid, null otherwise.
 */
interface BearerTokenValidator
{
    public function user(string $token): object|null;
}
