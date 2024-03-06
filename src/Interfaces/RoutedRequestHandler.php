<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/** See @class(Medas\Core\Interfaces\RoutedRequestHandlerManager) */
interface RoutedRequestHandler
{
    public function priority(): int;

    public function handles(string $method, string $path): bool;

    public function handle(string $method, string $path): mixed;
}
