<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A @class(Medas\Core\Interfaces\Collection) whose whole content can be replaced at once, for example by storage
 * when it has loaded the items.
 */
interface SettableCollection extends Collection
{
    /**
     * Replaces the content with `$data`. A collection that tracks changes takes it as the state it compares against,
     * so the new content doesn't count as changed.
     */
    public function setData(array $data): void;
}
