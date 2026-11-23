<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\{Identifier, Interfaces\DeclaresMaxStringLength, StringMaker};

/**
 * The base class of medas's exceptions. A subclass returns its message from `pattern()`, with a `%s` for each value,
 * and passes the values to this constructor.
 *
 * Each value is turned into a string with `StringMaker::fromPattern()`, cut off at 1000 characters, or at
 * `maxStringLength()` when the exception implements @class(Medas\Core\Interfaces\DeclaresMaxStringLength). The code
 * is always `1`.
 *
 * Besides the message, the exception keeps the values themselves, and a name for its message, so a client can show the
 * message in its own language.
 */
abstract class BaseException extends \Exception
{
    /**
     * Returns the message, with a placeholder for each value given to the constructor, as `vsprintf()` takes them.
     */
    abstract public function pattern(): string;

    private array $parameters;

    /**
     * @throws \ValueError When `pattern()` isn't a valid format, or has more placeholders than there are values.
     */
    public function __construct(...$arguments)
    {
        $this->parameters = $arguments;

        $maxStringLength = $this instanceof DeclaresMaxStringLength
            ? $this->maxStringLength()
            : null;

        $message = StringMaker::instance()->fromPattern(
            $this->pattern(),
            $arguments,
            maxStringLength: $maxStringLength
        );

        parent::__construct($message, 1, $this->previous());
    }

    /**
     * Returns the exception that caused this one. The constructor has no parameter for it, so a subclass that has one
     * overrides this method.
     *
     * The constructor calls it, so the subclass has to set what it returns before calling `parent::__construct()`, as a
     * promoted constructor property is.
     */
    public function previous(): \Throwable|null
    {
        return null;
    }

    /**
     * Returns the values the message was made from, as they were given, in the pattern's order, so a client can fill
     * them into its own translation of the message.
     */
    public function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * Returns a stable name for this message, so a client can look up its own translation: the short class name in
     * kebab case, like `'username-not-printable'` for `UsernameNotPrintable`.
     *
     * A subclass may override it. Renaming the class changes the name, and with it every translation stored under it.
     */
    public function messageIdentifier(): string
    {
        return new Identifier(new \ReflectionClass($this)->getShortName())->toKebabCase();
    }
}
