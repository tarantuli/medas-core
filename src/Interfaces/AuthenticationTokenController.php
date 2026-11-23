<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Creates authentication tokens from @class(Medas\Core\Interfaces\AuthenticationData), reads the data back, and ends
 * tokens where it can.
 *
 * Example:
 *
 * - @class(Medas\JwtTokens\JwtAuthTokenController) creates JWTs, which end when their lifetime runs out.
 */
interface AuthenticationTokenController
{
    /**
     * Returns a new token that carries `$data`.
     */
    public function create(AuthenticationData $data): string;

    /**
     * Ends the token, so `data()` returns `null` for it from then on, as far as the implementation can. A token that
     * can't be taken back, like a JWT without a revocation check, stays valid until it expires.
     */
    public function invalidate(string $token): void;

    /**
     * Returns the data in the token, or `null` when the token isn't valid: when it can't be verified, has expired or
     * has been ended.
     */
    public function data(string $token): AuthenticationData|null;

    /**
     * Returns the user ID from `data()`, or `null` when the token isn't valid.
     */
    public function userId(string $token): mixed;
}
