<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Indicates that there is a separate markdown file that contains documentation for this class or method.
 *
 * If no name is given, the filename is implied to be equal to the path to the class file, with the .php extension
 * replaced by .md for class documentation, and .{method name}.md for method documentation.
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
readonly class HasMarkdownDocumentation
{
    public function __construct(
        public string|null $fileName = null,
    )
    {
    }
}
