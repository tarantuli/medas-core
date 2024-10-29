<?php

declare(strict_types=1);

namespace Medas\Core;

#[Attributes\Service]
readonly class IdentifierMaker
{
    public function fromCamelCase(string $camelCase): Identifier
    {
        return new Identifier(mb_strtolower(preg_replace('/(.)(\p{Lu})/', '$1 $2', $camelCase)));
    }

    public function fromKebabCase(string $kebabCase): Identifier
    {
        return new Identifier(str_replace('-', ' ', $kebabCase));
    }

    public function fromPascalCase(string $pascalCase): Identifier
    {
        return new Identifier(str_replace('_', ' ', $pascalCase));
    }
}
