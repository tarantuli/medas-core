<?php

declare(strict_types=1);

namespace Medas\Core;

class Directory
{
    public static function recursiveFindByExtension(string $directory, string $extension): \RegexIterator
    {
        return self::recursiveFind($directory, sprintf('/\.%s$/i', preg_quote($extension)));
    }

    public static function recursiveFind(string $directory, string $pattern): \RegexIterator
    {
        return new \RegexIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $directory,
                    \FilesystemIterator::CURRENT_AS_PATHNAME | \FilesystemIterator::SKIP_DOTS
                )
            ),
            $pattern
        );
    }
}
