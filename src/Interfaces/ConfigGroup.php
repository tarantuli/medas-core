<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Groups related config options, and supplies the first parts of their path. See
 * @class(Medas\Core\Interfaces\ConfigOption) for how the path is built.
 */
interface ConfigGroup
{
    /**
     * The group this one is part of, or `null` for a top-level group, which is usually named after its package.
     */
    public function parent(): ConfigGroup|null;

    /**
     * This group's part of the path, without dots.
     */
    public function name(): string;
}
