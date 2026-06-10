<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class CallableDescriber
{
    public function describe(mixed $callable): string
    {
        // Closure
        if ($callable instanceof \Closure) {
            $ref = new \ReflectionFunction($callable);
            $file = basename($ref->getFileName() ?? 'unknown');
            $line = $ref->getStartLine();

            return "Closure in $file:$line";
        }

        // [object, 'method'] or ['ClassName', 'method']
        if (is_array($callable)) {
            [$target, $method] = $callable;
            $class = is_object($target) ? $target::class : $target;

            return "$class::$method()";
        }

        // 'ClassName::method' static string form
        if (is_string($callable) && str_contains($callable, '::')) {
            return "$callable()";
        }

        // Plain function name
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
