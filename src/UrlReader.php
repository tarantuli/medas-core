<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class UrlReader
{
    private \CurlHandle $handle;

    public function __construct()
    {
        $this->handle = curl_init();

        $this->initializeCurl();
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
        $this->handle = curl_init();

        $this->initializeCurl();
    }

    private function initializeCurl(): void
    {
        curl_setopt($this->handle, CURLOPT_POST, false);
        curl_setopt($this->handle, CURLOPT_HEADER, true);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, 10);
    }

    public function read(string $url): string
    {
        curl_setopt($this->handle, CURLOPT_URL, $url);

        $response = curl_exec($this->handle);
        $httpCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            throw new Exceptions\FailedToReadContent($url);
        }

        $headerSize = curl_getinfo($this->handle, CURLINFO_HEADER_SIZE);

        return substr($response, $headerSize);
    }
}
