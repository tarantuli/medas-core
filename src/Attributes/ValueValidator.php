<?php

declare(strict_types=1);

namespace Medas\Core\Attributes;

/**
 * Apply this attribute to methods of Type classes. This method can be used to validate values of this type
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class ValueValidator
{
}
