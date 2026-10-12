<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A compiled parameter (see CompilableParameterResolver and CompilableArgumentProcessor) whose outcome also depends on
 * classes other than the one the parameter belongs to. In development, a plan holding it is compiled again when one of
 * these files changes, just as when the class's own file changes.
 */
interface DependsOnSourceFiles
{
    /** @return string[] Absolute file paths */
    public function sourceFiles(): array;
}
