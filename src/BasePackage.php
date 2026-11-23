<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * The defaults for a @class(Medas\Core\Interfaces\Package): priority `0`, no development dependencies, not a test
 * package, nothing to do when it's initialised, ready or installed, and no Markdown documentation. When a package
 * turns the documentation on, it's looked for in `../documentation`, next to the source directory.
 *
 * A package still provides `dependencies()`, `sourceDirectory()` and `instance()`, usually with
 * @class(Medas\Core\AsSingleton).
 */
abstract class BasePackage implements Interfaces\Package
{
    public function priority(): int
    {
        return 0;
    }

    public function devDependencies(): array
    {
        return [];
    }

    public function isTestPackage(): bool
    {
        return false;
    }

    public function initialize(Interfaces\ServiceConfigBuilder $config): void
    {
        // Do nothing
    }

    public function ready(): void
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
