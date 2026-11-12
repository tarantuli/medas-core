<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

/**
 * Config option `core.debug-information-max-messages`: the number of messages `DebugInformationGatherer` keeps
 * before it drops the oldest ones.
 *
 * @see DebugInformationPruneCount
 */
#[Service]
readonly class DebugInformationMaxMessages implements ConfigOption
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
        return 'debug-information-max-messages';
    }

    public function description(): string
    {
        return 'The number of debug information messages at which the oldest ones are dropped';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 500;
    }
}
