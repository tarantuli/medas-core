<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class CouldNotResolveParameter extends BaseException
{
    public function __construct(\ReflectionParameter|\ReflectionProperty $parameter)
    {
        $declaringClass = $parameter->getDeclaringClass();

        // ObjectInstantiator::resolveParameter() also resolves properties, which have no declaring function
        if ($parameter instanceof \ReflectionProperty) {
            $message = $declaringClass->name;
        }
        elseif ($declaringClass) {
            $message = $declaringClass->name . '::' . $parameter->getDeclaringFunction()->name;
        }
        else {
            $message = $parameter->getDeclaringFunction()->name;
        }

        parent::__construct(
            '$' . $parameter->name,
            $message,
        );
    }

    public function pattern(): string
    {
        return 'could not resolve parameter %s in %s';
    }
}
