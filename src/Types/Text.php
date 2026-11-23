<?php

declare(strict_types=1);

namespace Medas\Core\Types;

/**
 * A text with a length between `$minLength` and `$maxLength`, 255 at most by default.
 *
 * The lengths are in UTF-8 characters, not bytes. pdo-mysql-migration-builder, for example, makes a `char` column
 * when both lengths are equal and at most 255, a `varchar` when they differ, and a `text` type above 255.
 *
 * Used for properties typed as `string` that have no type attribute.
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Text extends Binary
{
}
