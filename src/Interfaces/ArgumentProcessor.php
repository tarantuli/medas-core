<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Argument processors are called after a parameter to a method has been resolved. It should apply necessary
 * post-processing to the value.
 *
 * Examples:
 *
 * - @class(Medas\RestRequestHandler\Serializers\ArgumentDeserializer) is a processor that deserializes input from
 *   REST requests, replacing datetime strings by \DateTime objects.
 *
 * - @class(Medas\TypedDataArguments\TypedDataArgumentProcessor) is a processor that casts array values to instances
 *   of data objects, translating the array keys to object properties.
 *
 * Processors are applied in order of highest to lowest priority. Medas packages themselves have priorities lower than
 * zero.
 */
interface ArgumentProcessor extends DeclaresPriority
{
    public function process(\ReflectionParameter|\ReflectionProperty $parameter, mixed $argument): mixed;

    public function priority(): int;
}
