<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

use Medas\Core\{Attributes, Exceptions\EmptyIdentifier};

#[Attributes\Service]
readonly class IdentifierAnalyzer
{
    private const array SEPARATORS = [
        '-' => IdentifierType::KebabCase,
        '_' => IdentifierType::SnakeCase,
        ' ' => IdentifierType::SpaceCase
    ];

    /**
     * If the string is empty, throw an exception.
     * If the string contains any dashes, IdentifierType::KebabCase is returned.
     * If the string contains any underscores, IdentifierType::SnakeCase is returned.
     * If the string contains any spaces, IdentifierType::SpaceCase is returned.
     * If the string starts with an uppercase letter, IdentifierType::PascalCase is returned.
     * Otherwise, IdentifierType::CamelCase is returned.
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
