<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\Str;

abstract class BaseException extends \Exception
{
    private \Exception|null $previous = null;
    private array $arguments;

    public function __construct(...$arguments)
    {
        $this->arguments = $arguments;

        foreach ($arguments as &$argument) {
            try {
                $argument = Str::fromVariable($argument, true)
                    ->truncateToCharLength(1000);
            }
            catch (\Exception) {
                $argument = '�';
            }
        }

        $message = vsprintf($this->pattern(), $arguments);

        parent::__construct($message, 1, $this->previous);
    }

    abstract public function pattern(): string;

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
