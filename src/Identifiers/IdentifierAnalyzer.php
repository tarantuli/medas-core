<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

use Medas\Core\{Attributes, Exceptions\EmptyIdentifier};

/**
 * Determines the naming style of an identifier, like `'foo-bar'` or `'fooBar'`, so `Identifier` can convert it to other
 * styles.
 */
#[Attributes\Service]
readonly class IdentifierAnalyzer
{
    private const array SEPARATORS = [
        '-' => IdentifierType::KebabCase,
        '_' => IdentifierType::SnakeCase,
        ' ' => IdentifierType::SpaceCase
    ];

    /**
     * The first rule that matches decides:
     *
     * 1. It contains a `-`: `IdentifierType::KebabCase`.
     * 2. It contains a `_`: `IdentifierType::SnakeCase`.
     * 3. It contains a space: `IdentifierType::SpaceCase`.
     * 4. Its first byte is unchanged by `strtoupper()`: `IdentifierType::PascalCase`. That includes uppercase letters,
     *    but also digits and other characters without case.
     * 5. Otherwise: `IdentifierType::CamelCase`.
     *
     * @throws EmptyIdentifier When `$identifier` is `''`.
     */
    public function determine(string $identifier): IdentifierType
    {
        if ($identifier === '') {
            throw new EmptyIdentifier();
        }

        foreach (self::SEPARATORS as $separator => $type) {
            if (substr_count($identifier, $separator) > 0) {
                return $type;
            }
        }

        $firstChar = $identifier[0] ?? '';

        return $firstChar === strtoupper($firstChar)
            ? IdentifierType::PascalCase
            : IdentifierType::CamelCase;
    }
}
