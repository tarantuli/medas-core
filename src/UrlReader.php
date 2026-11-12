<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Fetches the body of a URL with a plain `GET` request, following redirects.
 *
 * @state Reuses one cURL handle for all requests, so cURL can keep connections open between calls.
 * @performance Blocks until the whole response has arrived, for at most `core.url-reader-transfer-timeout` seconds.
 * @notFor Other methods, request headers or bodies, or reading response headers; use the http-client package for
 *         those.
 */
#[Attributes\Service]
readonly class UrlReader
{
    private \CurlHandle $handle;

    /**
     * @throws Exceptions\FailedToInitializeCurl When cURL can't create a handle.
     */
    public function __construct(
        /** Seconds to wait for a connection to be made. */
        #[Attributes\ConfigValue(ConfigOptions\UrlReaderConnectTimeout::class)]
        private int $connectTimeout = 10,

        /** Seconds the whole request may take, connecting included. `0` means no limit. */
        #[Attributes\ConfigValue(ConfigOptions\UrlReaderTransferTimeout::class)]
        private int $transferTimeout = 30,
    )
    {
        $this->initializeCurl();
    }

    /**
     * Keeps only the timeouts. A cURL handle can't be serialized, so a new one is created when unserializing.
     */
    public function __serialize(): array
    {
        return [
            'connectTimeout' => $this->connectTimeout,
            'transferTimeout' => $this->transferTimeout,
        ];
    }

    /**
     * @throws Exceptions\FailedToInitializeCurl When cURL can't create a handle.
     */
    public function __unserialize(array $data): void
    {
        $this->connectTimeout = $data['connectTimeout'];
        $this->transferTimeout = $data['transferTimeout'];

        $this->initializeCurl();
    }

    /**
     * @throws Exceptions\FailedToInitializeCurl When cURL can't create a handle.
     */
    private function initializeCurl(): void
    {
        $handle = curl_init();

        if ($handle === false) {
            throw new Exceptions\FailedToInitializeCurl();
        }

        $this->handle = $handle;

        curl_setopt($this->handle, CURLOPT_POST, false);
        curl_setopt($this->handle, CURLOPT_HEADER, true);
        curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($this->handle, CURLOPT_TIMEOUT, $this->transferTimeout);
    }

    /**
     * Returns the body of the response, without its headers.
     *
     * @throws Exceptions\FailedToReadContent When the request fails, or the final response, after redirects, has a
     *                                        status outside 200-299.
     */
    public function read(string $url): string
    {
        curl_setopt($this->handle, CURLOPT_URL, $url);

        $response = curl_exec($this->handle);

        if ($response === false) {
            throw new Exceptions\FailedToReadContent($url, curl_error($this->handle));
        }

        $httpCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new Exceptions\FailedToReadContent($url, "HTTP $httpCode");
        }

        $headerSize = curl_getinfo($this->handle, CURLINFO_HEADER_SIZE);

        return substr($response, $headerSize);
    }
}
