<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

interface Package extends IsSingleton
{
    public function priority(): int;

    /** @return Package[] */
    public function dependencies(): array;

    public function sourceDirectory(): string;

    public function isTestPackage(): bool;

    public function initialize(ServiceConfig $config): void;

    /**
     * Called after all packages have been initialized, with the full service container available.
     * Use for non-cacheable runtime setup that requires service resolution.
     */
    public function ready(): void;

    public function postInstall(): void;

    /**
     * Whether the package has a directory containing Markdown documentation, starting with an index.md file.
     */
    public function hasMarkdownDocumentation(): bool;

    /**
     * The path to the directory containing Markdown documentation relative to the source directory.
     */
    public function markdownDocumentationDirectory(): string;
}
