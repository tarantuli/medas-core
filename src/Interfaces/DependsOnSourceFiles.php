<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Implemented by the object that `compile()` of a @class(Medas\Core\Interfaces\CompilableParameterResolver) or
 * @class(Medas\Core\Interfaces\CompilableArgumentProcessor) returns, when it also depends on files other than the one
 * of the class the parameter belongs to. In development mode, the parameter is then compiled again when one of these
 * files changes, just as when the class's own file changes. Outside development mode it has no effect: nothing is
 * compiled again until the caches are cleared.
 *
 * @class(Medas\ConfigOptions\CompiledConfigValue), for example, lists the files of the config option and its groups,
 * so a changed name or default is picked up.
 */
interface DependsOnSourceFiles
{
    /** @return string[] Absolute file paths */
    public function sourceFiles(): array;
}
