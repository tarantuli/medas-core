<?php

declare(strict_types=1);

namespace Medas\Core\StringMaker;

/**
 * How @class(Medas\Core\StringMaker) writes values.
 */
class Settings
{
    /**
     * Returns the settings for showing values to people: quotes only where they're needed, and only valid UTF-8.
     */
    public static function forDisplay(): static
    {
        return new static(true, true);
    }

    /**
     * @param bool $quotesOnlyAroundWhitespace Only puts strings in quotes when they're empty or contain whitespace,
     *                                         instead of always.
     * @param bool $forceUtf8                  Replaces invalid UTF-8 bytes; see `StringMaker::forceUtf8()`.
     * @param bool $alwaysAddClass             Also writes the class of a `\Stringable` object, instead of only its
     *                                         string.
     * @param bool $useObjectIds               Writes the ID of each object after its class, like `Foo[12]`.
     */
    public function __construct(
        public bool $quotesOnlyAroundWhitespace = false,
        public bool $forceUtf8 = false,
        public bool $alwaysAddClass = false,
        public bool $useObjectIds = true,
    )
    {
    }
}
