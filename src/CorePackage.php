<?php

declare(strict_types=1);

namespace Medas\Core;

class CorePackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }

    /**
     * Binds `$isDev` of `Today`, so `Today::set()` works in dev and test environments without each application
     * binding it.
     */
    public function initialize(Interfaces\ServiceConfigBuilder $config): void
    {
        $config->addManualBinding(Today::class, 'isDev', $config->isDev);
    }

    public function loadGlobalFunctions(): void
    {
        require_once __DIR__ . '/GlobalFunctions.php';
    }

    public function hasMarkdownDocumentation(): bool
    {
        return true;
    }
}
