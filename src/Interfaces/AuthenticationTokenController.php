<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * An authentication token controller creates tokens based on data, invalidates tokens, and retrieves data from tokens.
 */
interface AuthenticationTokenController
{
    public function create(AuthenticationData $data): string;

    public function invalidate(string $token): void;

    public function data(string $token): AuthenticationData;

    public function userId(string $token): mixed;
}
