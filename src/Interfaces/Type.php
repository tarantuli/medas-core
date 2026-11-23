<?php

declare(strict_types=1);

namespace Medas\Core\Interfaces;

/**
 * A data type in the most general sense, like a text of at most 255 characters, or an integer within a range.
 *
 * The types in `Medas\Core\Types`, like @class(Medas\Core\Types\Text), are attributes: entity properties are marked
 * with them to say how they're stored. A serialiser can be given one, to know what to convert a value back into.
 */
interface Type
{
}
