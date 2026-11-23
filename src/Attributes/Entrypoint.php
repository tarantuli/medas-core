<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks a class or method as a good starting point for people who want to use or discover a package.
 *
 * Use it on the few most important public entrypoints to the functionality of a package. The documentation generator
 * highlights them, and marks a class that has entrypoint methods.
 *
 * @notFor Anything at runtime; only the documentation reads it.
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
readonly class Entrypoint
{
}
