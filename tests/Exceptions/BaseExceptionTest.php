<?php

declare(strict_types=1);

namespace Medas\CoreTest\Exceptions;

use Medas\Core\Exceptions\BaseException;
use Medas\CoreTest\BaseTestClass;

class BaseExceptionTest extends BaseTestClass
{
    public function testMessageIdentifierIsTheKebabCasedShortClassName(): void
    {
        self::assertSame('username-not-printable', new UsernameNotPrintable()->messageIdentifier());
        self::assertSame('invalid-json-body', new InvalidJsonBody()->messageIdentifier());
    }

    public function testMessageIdentifierCanBeOverridden(): void
    {
        self::assertSame('renamed', new WithOwnIdentifier()->messageIdentifier());
    }

    public function testParametersAreTheArgumentsInPatternOrder(): void
    {
        $exception = new TwoParameters('first', 2);

        self::assertSame(['first', 2], $exception->parameters());
        self::assertSame('first and 2', $exception->getMessage());
        self::assertSame([], new UsernameNotPrintable()->parameters());
    }
}

class UsernameNotPrintable extends BaseException
{
    public function pattern(): string
    {
        return 'not printable';
    }
}

class InvalidJsonBody extends BaseException
{
    public function pattern(): string
    {
        return 'invalid body';
    }
}

class WithOwnIdentifier extends BaseException
{
    public function pattern(): string
    {
        return 'own identifier';
    }

    public function messageIdentifier(): string
    {
        return 'renamed';
    }
}

class TwoParameters extends BaseException
{
    public function pattern(): string
    {
        return '%s and %s';
    }
}
