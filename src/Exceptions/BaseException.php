<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\{Identifier, Interfaces\DeclaresMaxStringLength, StringMaker};

abstract class BaseException extends \Exception
{
    abstract public function pattern(): string;

    // The arguments the message was made from, in the pattern's order, so a client
    // can fill them into its own translation of the message (messageIdentifier()).
    private array $parameters;

    public function __construct(...$arguments)
    {
        $this->parameters = $arguments;

        $maxStringLengh = $this instanceof DeclaresMaxStringLength
            ? $this->maxStringLength()
            : null;

        $message = StringMaker::instance()->fromPattern(
            $this->pattern(),
            $arguments,
            maxStringLength: $maxStringLengh
        );

        parent::__construct($message, 1, $this->previous());
    }

    public function previous(): \Throwable|null
    {
        return null;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    // A stable, machine-readable name for this message, so a client can show it in
    // its own language: the short class name in kebab case (UsernameNotPrintable is
    // username-not-printable). A class may override it; renaming the class changes the
    // identifier, and with it every client translation keyed on it.
    public function messageIdentifier(): string
    {
        return new Identifier(new \ReflectionClass($this)->getShortName())->toKebabCase();
    }
}
