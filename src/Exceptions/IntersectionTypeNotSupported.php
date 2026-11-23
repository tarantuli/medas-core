<?php

declare(strict_types=1);

namespace Medas\Core\Exceptions;

class IntersectionTypeNotSupported extends BaseException
{
    private static function describe(\ReflectionParameter|\ReflectionProperty $reflector): string
    {
        if ($reflector instanceof \ReflectionProperty) {
            return $reflector->getDeclaringClass()->name . '::$' . $reflector->name;
        }

        // Parameters of closures and functions have no declaring class
        $class = $reflector->getDeclaringClass()?->name;
        $function = $reflector->getDeclaringFunction()->name;

        return ($class !== null ? $class . '::' : '')
            . $function
            . '() parameter $'
            . $reflector->name;
    }

    public function __construct(
        \ReflectionParameter|\ReflectionProperty $reflector,
        \ReflectionIntersectionType              $type,
    )
    {
        parent::__construct((string) $type, self::describe($reflector));
    }

    public function pattern(): string
    {
        return 'the intersection type %s of %s is not supported';
    }
}
