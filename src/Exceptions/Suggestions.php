<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

/**
 * Lets an exception tell whoever reads it what to do about it, such as what probably caused it, a binding to add, or a
 * package that solves the problem.
 */
interface Suggestions
{
    /**
     * Returns the suggestions, written like the messages: in lower case, without a full stop.
     *
     * Each item is either a suggestion, or a suggestion as the key with an indentation level as the value, to show it
     * as a detail of the one before it. @class(Medas\ConsolePrinter\ExceptionPrinter) indents it by that many steps.
     *
     * @return array<int|string, string|int>
     */
    public function suggestions(): array;
}
