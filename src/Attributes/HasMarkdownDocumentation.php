<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Tells the documentation generator that a class or method is documented in a separate Markdown file, for
 * explanations too long for a docblock.
 *
 * The file's content replaces the description of the docblock; the tags in the docblock still appear next to it.
 *
 * Without `$fileName`, the file is next to the class file, with the same name: `.php` becomes `.md` for a class, and
 * `.$methodName.md` for a method. So the documentation of `Foo::bar()` is in `Foo.bar.md`.
 *
 * The generator stops with `FileDoesNotExist` when the file isn't there.
 *
 * @assumes A given `$fileName` is used as it is, so it must be absolute, or relative to the directory the generator
 *          runs in.
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
