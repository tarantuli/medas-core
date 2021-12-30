<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\Str;

abstract class BaseException extends \Exception
{
    abstract public function pattern(): string;

    private ?\Exception $previous = null;
    private array $arguments;

    public function __construct(...$arguments)
    {
        $this->arguments = $arguments;
        foreach ($arguments as &$argument) {
            $argument = Str::fromVariable($argument)->truncateToCharLength(255);
        }

        $message = vsprintf($this->pattern(), $arguments);

        parent::__construct($message, 1, $this->previous);
    }

    public function arguments(): array
    {
        return $this->arguments;
    }

    public function setPrevious(?\Exception $previous): self
    {
        $this->previous = $previous;

        return $this;
    }
}
