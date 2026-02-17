<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

use Medas\Core\Attributes;

#[Attributes\Service]
readonly class IdentifierAnalyzer
{
    private const array SEPARATORS = [
        '-' => IdentifierType::KebabCase,
        '_' => IdentifierType::SnakeCase,
        ' ' => IdentifierType::SpaceCase
    ];

    public function determine(string $identifier): IdentifierType
    {
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
