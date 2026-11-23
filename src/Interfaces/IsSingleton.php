<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Marks classes that have one instance only, which `instance()` returns.
 *
 * It's meant for classes that hold neither data, which belongs in data classes, nor behaviour, which belongs in
 * @class(Medas\Core\Attributes\Service) classes. Use the @class(Medas\Core\AsSingleton) trait to implement it.
 *
 * Example:
 *
 * - Every @class(Medas\Core\Interfaces\Package) is a singleton: it describes the package as a whole.
 */
interface IsSingleton
{
    public static function instance(): self;
}
