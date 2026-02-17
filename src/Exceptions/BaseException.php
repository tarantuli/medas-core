<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\StringMaker;

abstract class BaseException extends \Exception
{
    abstract public function pattern(): string;

    public function __construct(...$arguments)
    {
        $message = StringMaker::instance()->fromPattern($this->pattern(), $arguments);

        parent::__construct($message, 1, $this->previous());
    }

    public function previous(): \Throwable|null
    {
        return null;
    }
}
