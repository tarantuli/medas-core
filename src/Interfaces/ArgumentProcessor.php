<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface ArgumentProcessor
{
    public function process(\ReflectionParameter|\ReflectionProperty $parameter, mixed $argument): mixed;

    public function priority(): int;
}
