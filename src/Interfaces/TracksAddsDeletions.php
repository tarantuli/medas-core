<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface TracksAddsDeletions
{
    public function getAdditions(): array;

    public function getDeletions(): array;
}
