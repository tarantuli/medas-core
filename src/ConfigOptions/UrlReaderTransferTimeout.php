<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

/**
 * Config option `core.url-reader-transfer-timeout`: how many seconds a request of `UrlReader` may take in total,
 * connecting included. `0` means no limit.
 *
 * It's passed to cURL as `CURLOPT_TIMEOUT`.
 */
#[Service]
readonly class UrlReaderTransferTimeout implements ConfigOption
{
    public function __construct(
        private CoreGroup $group,
    )
    {
    }

    public function group(): ConfigGroup
    {
        return $this->group;
    }

    public function name(): string
    {
        return 'url-reader-transfer-timeout';
    }

    public function description(): string
    {
        return 'The maximum number of seconds a request via cURL may take, including connecting';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 30;
    }
}
