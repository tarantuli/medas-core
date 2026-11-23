<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A medas package, as the service manager sees it: where its services are, which packages it needs, and what it adds
 * to the service configuration.
 *
 * Extend @class(Medas\Core\BasePackage) for the defaults, and use @class(Medas\Core\AsSingleton) for `instance()`.
 *
 * @assumes There's one instance per class, which `instance()` returns. Packages are referred to by their class in the
 *          cached configuration, and fetched again with `instance()`.
 * @see ServiceConfigBuilder
 */
interface Package extends IsSingleton, DeclaresPriority
{
    /**
     * Packages are initialised and made ready in order of priority, highest first.
     */
    public function priority(): int;

    /**
     * The packages this package needs. They're added, with their services, whenever this package is added.
     *
     * @return Package[]
     */
    public function dependencies(): array;

    /**
     * Like `dependencies()`, but only added in development mode.
     *
     * @return Package[]
     */
    public function devDependencies(): array;

    /**
     * The absolute path of the directory with the package's classes, usually `__DIR__`. Every non-abstract class marked
     * with @class(Medas\Core\Attributes\Service) whose file is in that directory becomes a service. To find them, every
     * class file in it is loaded when the package is added.
     */
    public function sourceDirectory(): string;

    /**
     * Whether the class files are loaded with `require_once` instead of through the Composer autoloader, for test
     * packages whose classes the autoloader doesn't know.
     */
    public function isTestPackage(): bool;

    /**
     * Adds the package's resolvers, processors, bindings and exception handlers to the configuration.
     *
     * It's called once while the configuration is built, so not when it comes from the cache. Anything that has to
     * happen in every process belongs in `ready()`.
     */
    public function initialize(ServiceConfigBuilder $config): void;

    /**
     * Called in every process, once the service manager is ready and services can be resolved. Use it for setup that
     * can't be cached.
     */
    public function ready(): void;

    /**
     * Called after `composer install`, `composer update` and similar scripts, once all caches have been cleared.
     */
    public function postInstall(): void;

    /**
     * Whether the package has a directory with Markdown documentation, starting with an `index.md` file.
     */
    public function hasMarkdownDocumentation(): bool;

    /**
     * The path of the directory with the Markdown documentation, relative to the source directory.
     */
    public function markdownDocumentationDirectory(): string;
}
