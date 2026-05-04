<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Classes marked with this attribute define another class that handles casting to and from arrays. That other class
 * should implement the ObjectToArrayHandler interface
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class ObjectToArrayHandler
{
    public function __construct(
        public string $className,
    )
    {
    }
}
