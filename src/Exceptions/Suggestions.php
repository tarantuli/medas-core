<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

interface Suggestions
{
    /** @return string[] */
    public function suggestions(): array;
}
