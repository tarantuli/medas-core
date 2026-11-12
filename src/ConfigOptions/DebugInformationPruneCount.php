<?php

declare(strict_types=1);

namespace Medas\Core\ConfigOptions;

use Medas\Core\{Attributes\Service, Interfaces\ConfigGroup, Interfaces\ConfigOption};

/**
 * Config option `core.debug-information-prune-count`: how many of the oldest messages `DebugInformationGatherer`
 * drops at once when it has reached `core.debug-information-max-messages`, so that doesn't happen for every new
 * message. At least one is always dropped.
 *
 * @see DebugInformationMaxMessages
 */
#[Service]
readonly class DebugInformationPruneCount implements ConfigOption
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
        return 'debug-information-prune-count';
    }

    public function description(): string
    {
        return 'How many of the oldest debug information messages are dropped at once';
    }

    public function hasDefault(): bool
    {
        return true;
    }

    public function default(): int
    {
        return 50;
    }
}
