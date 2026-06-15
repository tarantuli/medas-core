<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

use Medas\Core\{Interfaces\DeclaresMaxStringLength, StringMaker};

abstract class BaseException extends \Exception
{
    abstract public function pattern(): string;

    public function __construct(...$arguments)
    {
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
}
