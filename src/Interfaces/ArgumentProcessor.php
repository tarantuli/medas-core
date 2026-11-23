<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * Post-processes an argument after it has been resolved or given, for the
 * @class(Medas\Core\Interfaces\ObjectInstantiator), like converting a string into the object the parameter expects.
 * Packages register their processors with `ServiceConfigBuilder::addArgumentProcessor()`.
 *
 * Every processor is applied in turn, in order of priority, highest first, and gets the result of the one before it.
 * Medas packages themselves use priorities below zero.
 *
 * Examples:
 *
 * - @class(Medas\RestRequestHandler\Serializers\ArgumentDeserializer) deserialises input from REST requests, like
 *   date-time strings into `\DateTime` objects.
 * - @class(Medas\TypedDataArguments\TypedDataArgumentProcessor) turns arrays into instances of data objects, setting
 *   their properties from the array keys.
 *
 * @assumes The object instantiator creates processors itself, with `new` and without arguments, so they can't have
 *          dependencies injected.
 * @state One instance may be used for the whole process, so a processor mustn't keep anything that differs per
 *        request.
 * @notFor Resolving a parameter that has no value yet; use a @class(Medas\Core\Interfaces\ParameterResolver).
 * @see CompilableArgumentProcessor
 */
interface ArgumentProcessor extends DeclaresPriority
{
    /**
     * Returns the processed argument, or `$argument` itself when this processor doesn't apply to it.
     */
    public function process(\ReflectionParameter|\ReflectionProperty $parameter, mixed $argument): mixed;

    public function priority(): int;
}
