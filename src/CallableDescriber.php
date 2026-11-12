<?php

declare(strict_types=1);

namespace Medas\Core;

/**
 * Describes a callable in a single line, like `'Foo::bar()'` or `'Closure in Foo.php:12'`, for listings such as
 * `events:list-listeners`.
 *
 * A closure is described by the name of its file, without the directory, and the line it starts on. A closure of an
 * internal function or method, like `strlen(...)`, has no file, so it's described by that function or method instead:
 * `'Closure of strlen()'`.
 *
 * @assumes Arrays are `[$objectOrClass, $method]` pairs.
 * @notFor Checking whether a value is callable. Any string, array or object is described as if it were one; only other
 *         values become `'(unknown callable)'`.
 */
#[Attributes\Service]
readonly class CallableDescriber
{
    public function describe(mixed $callable): string
    {
        // Closure
        if ($callable instanceof \Closure) {
            $ref = new \ReflectionFunction($callable);
            $file = $ref->getFileName();

            // Closures of internal functions and methods have no file
            if ($file === false) {
                $class = $ref->getClosureScopeClass()?->getName();

                return $class === null
                    ? "Closure of {$ref->getName()}()"
                    : "Closure of $class::{$ref->getName()}()";
            }

            return 'Closure in ' . basename($file) . ':' . $ref->getStartLine();
        }

        // [object, 'method'] or ['ClassName', 'method']
        if (is_array($callable)) {
            [$target, $method] = $callable;
            $class = is_object($target) ? $target::class : $target;

            return "$class::$method()";
        }

        // 'ClassName::method' static string form, or a plain function name
        if (is_string($callable)) {
            return "$callable()";
        }

        // Invokable object
        if (is_object($callable)) {
            return $callable::class . '::__invoke()';
        }

        return '(unknown callable)';
    }
}
