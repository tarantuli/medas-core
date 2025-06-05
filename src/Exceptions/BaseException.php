<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\StringMaker;

abstract class BaseException extends \Exception
{
    abstract public function pattern(): string;

    private \Exception|null $previous = null;
    private array $arguments;

    public function __construct(...$arguments)
    {
        $this->arguments = $arguments;
        $message = StringMaker::instance()->fromPattern($this->pattern(), $arguments);

        parent::__construct($message, 1, $this->previous);
    }

    public function arguments(): array
    {
        return $this->arguments;
    }

    public function setPrevious(\Exception|null $previous): self
    {
        $this->previous = $previous;

        return $this;
    }
}
