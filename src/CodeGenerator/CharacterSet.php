<?php

declare(strict_types=1);

namespace Medas\Core\CodeGenerator;

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
    case SafeSymbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    case UnsafeSymbols = '~`\\"\'/';
}
