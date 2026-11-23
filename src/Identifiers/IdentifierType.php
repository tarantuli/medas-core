<?php

declare(strict_types=1);

namespace Medas\Core\Identifiers;

/**
 * The naming style of an identifier, as @class(Medas\Core\Identifiers\IdentifierAnalyzer) determines it.
 */
enum IdentifierType
{
    /** Like `'userName'`. */
    case CamelCase;

    /** Like `'user-name'`. */
    case KebabCase;

    /** Like `'UserName'`. */
    case PascalCase;

    /** Like `'user_name'`. */
    case SnakeCase;

    /** Like `'user name'`. */
    case SpaceCase;
}
