<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class UrlReader
{
    private \CurlHandle $handle;

    public function __construct(
        #[Attributes\ConfigValue(ConfigOptions\UrlReaderConnectTimeout::class)]
        private int $connectTimeout = 10,
    )
    {
        $handle = curl_init();

        if ($handle === false) {
            throw new Exceptions\FailedToInitializeCurl();
        }

        $this->handle = $handle;

        $this->initializeCurl();
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
        $handle = curl_init();

        if ($handle === false) {
            throw new Exceptions\FailedToInitializeCurl();
        }

        $this->handle = $handle;

        $this->initializeCurl();
    }

    private function initializeCurl(): void
    {
        curl_setopt($this->handle, CURLOPT_POST, false);
        curl_setopt($this->handle, CURLOPT_HEADER, true);
        curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
    }

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
