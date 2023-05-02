<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface RoutedRequestHandlerGeneratesEndpoint
{
    public function endpoint(array $arguments = []): string;
}
