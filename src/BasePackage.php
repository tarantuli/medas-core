<?php

declare(strict_types=1);

namespace Medas\Core;

abstract class BasePackage implements Interfaces\Package
{
    public function priority(): int
    {
        return 0;
    }

    public function isTestPackage(): bool
    {
        return false;
    }

    public function initialize(Interfaces\ServiceConfig $config): void
    {
        // Do nothing
    }

    public function postInstall(): void
    {
        // Do nothing
    }

    public function hasMarkdownDocumentation(): bool
    {
        return false;
    }

    public function markdownDocumentationDirectory(): string
    {
        return '../documentation';
    }
}
