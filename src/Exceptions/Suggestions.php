<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * Exceptions that implement this interface should provide suggestions that the system can provide to the user. They
 * may contain:
 *
 * - Hints to the cause of the exceptions
 * - Packages that can be installed to alleviate the problem
 */
interface Suggestions
{
    /** @return string[] */
    public function suggestions(): array;
}
