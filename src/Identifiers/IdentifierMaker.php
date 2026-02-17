<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

use Medas\Core\{Attributes, Identifier};

#[Attributes\Service]
readonly class IdentifierMaker
{
    public function fromCamelCase(string $camelCase): Identifier
    {
        // Handled by the Identifier constructor
        return new Identifier($camelCase);
    }

    public function fromKebabCase(string $kebabCase): Identifier
    {
        // Handled by the Identifier constructor
        return new Identifier($kebabCase);
    }

    public function fromPascalCase(string $pascalCase): Identifier
    {
        // Handled by the Identifier constructor
        return new Identifier($pascalCase);
    }
}
