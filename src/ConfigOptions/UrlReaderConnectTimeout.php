<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

/**
 * Config option `core.url-reader-connect-timeout`: how many seconds `UrlReader` waits for a connection to be made.
 *
 * It only limits connecting (`CURLOPT_CONNECTTIMEOUT`). `core.url-reader-transfer-timeout` limits the whole request.
 */
#[Service]
readonly class UrlReaderConnectTimeout implements ConfigOption
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
        return 'url-reader-connect-timeout';
    }

    public function description(): string
    {
        return 'The maximum number of seconds to wait when connecting to a URL via cURL';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 10;
    }
}
