<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

enum IdentifierType
{
    case CamelCase;
    case KebabCase;
    case PascalCase;
    case SnakeCase;
    case SpaceCase;
}
