<?php

declare(strict_types=1);

namespace Medas\Core\Cors;

use Medas\Core\Attributes\Service;

/**
 * Pure CORS decision logic, shared between anything that needs to write
 * CORS headers regardless of how it dispatches requests or writes
 * responses (e.g., Medas\HttpRequestHandler's Job-based response pipeline,
 * or Medas\HttpFileServer's plain header() calls). This class only decides
 * *which* headers to set and to what value - it never writes anything
 * itself, so it has no dependency on any particular request/response
 * abstraction.
 */
#[Service]
readonly class CorsHeaders
{
    /**
     * Headers for a normal (non-preflight) response. Returns an empty array
     * if the origin isn't allowed (or the allowlist is empty) - the caller
     * should then simply not add any header at all, letting the browser's
     * own CORS enforcement reject the response, rather than asserting a
     * denial explicitly.
     *
     * @param string[] $allowedOrigins Exact-match origins, or ['*'] to allow any
     * @param string[] $exposedHeaders Extra response headers JS is allowed to read cross-origin
     * @return array<string, string>
     */
    public function resolveResponseHeaders(
        array  $allowedOrigins,
        string $requestOrigin,
        int    $maxAge = 0,
        array  $exposedHeaders = [],
    ): array
    {
        if ($allowedOrigins === []) {
            return [];
        }

        $isAllowed = in_array('*', $allowedOrigins, true)
            || in_array($requestOrigin, $allowedOrigins, true);

        if (!$isAllowed) {
            return [];
        }

        // Strips control characters before reflecting the origin back into
        // a response header - relevant in wildcard mode specifically, where
        // any origin is accepted verbatim rather than checked against a
        // pre-configured, already-trusted allowlist. Prevents a crafted
        // Origin value (e.g., containing \r\n) from splitting the response
        // into extra headers.
        $requestOrigin = str_replace(["\r", "\n", "\0"], '', $requestOrigin);

        $headers = [
            'Access-Control-Allow-Origin' => $requestOrigin,
            'Access-Control-Allow-Credentials' => 'true',
        ];

        if ($exposedHeaders !== []) {
            $headers['Access-Control-Expose-Headers'] = implode(', ', $exposedHeaders);
        }

        if ($maxAge > 0) {
            $headers['Access-Control-Max-Age'] = (string) $maxAge;
        }

        return $headers;
    }

    /**
     * The extra headers a preflight (OPTIONS) response needs, on top of
     * whatever resolveResponseHeaders() already provides.
     *
     * @param string[] $allowedMethods
     * @return array<string, string>
     */
    public function resolvePreflightHeaders(array $allowedMethods, string $requestedHeaders): array
    {
        $headers = [
            'Access-Control-Allow-Methods' => implode(', ', $allowedMethods),
        ];

        if ($requestedHeaders !== '') {
            // Prevents a crafted Access-Control-Request-Headers value from
            // splitting the response into extra headers - browsers
            // themselves constrain this value, but nothing stops a
            // non-browser client from sending an arbitrary one directly.
            $headers['Access-Control-Allow-Headers'] = str_replace(
                ["\r", "\n", "\0"],
                '',
                $requestedHeaders
            );
        }

        return $headers;
    }
}
