<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class CannotInstantiateClassWithParameters extends BaseException
{
    public function __construct(\ReflectionClass $class)
    {
        /**
         * The second element will be cast to string by the parent constructor
         */
        parent::__construct($class->getName(), $class->getConstructor()->getParameters());
    }

    public function pattern(): string
    {
        return 'cannot instantiate class %s because the constructor requires parameters: %s';
    }
}
