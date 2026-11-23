<?php

declare(strict_types=1);

namespace Medas\Core\CodeGenerator;

/**
 * The characters @class(Medas\Core\CodeGenerator) can pick from. Each case's value holds its characters.
 */
enum CharacterSet: string
{
    case Digits = '0123456789';
    case LowerLetters = 'abcdefghijklmnopqrstuvwxyz';
    case UpperLetters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    case HexLower = '0123456789abcdef';
    case HexUpper = '0123456789ABCDEF';
    case AlphaNumeric = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    case Base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
    case Base64UrlSafe = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';

    /** Symbols other than those in `UnsafeSymbols`. */
    case SafeSymbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';

    /** The tilde, the backtick, the backslash, quotes and the slash, which often need escaping. */
    case UnsafeSymbols = '~`\\"\'/';
}
