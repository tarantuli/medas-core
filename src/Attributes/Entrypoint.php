<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Classes and methods marked with this attribute are good starting points for people who want
 * to use or discover a package.
 *
 * Use this attribute to mark the most important public entrypoints to the functionality of a package.
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
readonly class Entrypoint
{
}
