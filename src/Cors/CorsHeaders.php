<?php

declare(strict_types=1);

namespace Medas\Core\Cors;

use Medas\Core\Attributes\Service;

/**
 * Decides which CORS headers a response gets, so request handlers that dispatch requests and write responses in
 * different ways can share the same rules.
 *
 * It has no dependency on any request or response abstraction. http-request-handler uses it in its job-based response
 * pipeline, and http-file-server with plain `header()` calls.
 *
 * @notFor Reading the request or writing headers; the caller passes in the request values and writes the result.
 */
#[Service]
readonly class CorsHeaders
{
    /**
     * Headers for a normal, non-preflight response.
     *
     * Returns an empty array when the origin isn't allowed, or `$allowedOrigins` is empty. The caller should then add
     * no CORS headers at all, and let the browser's own CORS enforcement reject the response, rather than assert a
     * denial.
     *
     * An origin that's listed is echoed back, together with `Access-Control-Allow-Credentials: true` and
     * `Vary: Origin`. Any other origin, allowed by `'*'`, gets `Access-Control-Allow-Origin: *` without credentials, so
     * browsers won't send cookies or authorization along. List an origin explicitly when it needs credentials.
     *
     * @param string[] $allowedOrigins Exact-match origins, or `['*']` to allow any.
     * @param string   $requestOrigin  The value of the request's `Origin` header.
     * @param int      $maxAge         In seconds. `Access-Control-Max-Age` is only added when it's above `0`.
     * @param string[] $exposedHeaders Extra response headers that scripts may read cross-origin.
     *
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

        $isListed = in_array($requestOrigin, $allowedOrigins, true);

        if (!$isListed && !in_array('*', $allowedOrigins, true)) {
            return [];
        }

        if ($isListed) {
            // Only an origin that equals a configured one is echoed back, so it never needs sanitizing. The response
            // differs per origin, so caches must keep them apart.
            $headers = [
                'Access-Control-Allow-Origin' => $requestOrigin,
                'Access-Control-Allow-Credentials' => 'true',
                'Vary' => 'Origin',
            ];
        }
        else {
            // Echoing an arbitrary origin with credentials would let any site make requests with the user's cookies,
            // so the wildcard only allows requests without credentials
            $headers = [
                'Access-Control-Allow-Origin' => '*',
            ];
        }

        if ($exposedHeaders !== []) {
            $headers['Access-Control-Expose-Headers'] = implode(', ', $exposedHeaders);
        }

        if ($maxAge > 0) {
            $headers['Access-Control-Max-Age'] = (string) $maxAge;
        }

        return $headers;
    }

    /**
     * The extra headers a preflight (`OPTIONS`) response needs, on top of what `resolveResponseHeaders()` returns.
     *
     * Every requested header is allowed: `$requestedHeaders` is echoed back, without control characters.
     *
     * @param string[] $allowedMethods
     * @param string   $requestedHeaders The value of the request's `Access-Control-Request-Headers` header.
     *
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
