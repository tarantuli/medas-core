<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Marks the method of a type class, like `Types\EmailAddress`, that checks whether a value is valid for that type.
 *
 * The method takes the value and returns whether it's valid.
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class ValueValidator
{
}
