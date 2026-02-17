<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class CannotInstantiateClassWithParameters extends BaseException
{
    public function __construct(\ReflectionClass $class)
    {
        parent::__construct($class->getName(), $class->getConstructor()->getParameters());
    }

    public function pattern(): string
    {
        return 'cannot instantiate class %s because the constructor requires parameters: %s';
    }
}
