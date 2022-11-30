<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\Identifier;

class IdentifierTest extends BaseTest
{
    public function testCreateFromString(): Identifier
    {
        $identifier = new Identifier('Variable ID  with   spaces');

        self::assertInstanceOf(Identifier::class, $identifier);

        return $identifier;
    }

    /** @depends testCreateFromString */
    public function testCamelCase(Identifier $identifier): void
    {
        self::assertEquals('variableIdWithSpaces', $identifier->toCamelCase());
    }

    /** @depends testCreateFromString */
    public function testCamelCaseWithPrefix(Identifier $identifier): void
    {
        self::assertEquals('getVariableIdWithSpaces', $identifier->toCamelCase('get'));
    }

    /** @depends testCreateFromString */
    public function testPascalCase(Identifier $identifier): void
    {
        self::assertEquals('VariableIdWithSpaces', $identifier->toPascalCase());
    }

    /** @depends testCreateFromString */
    public function testPascalCaseWithPrefix(Identifier $identifier): void
    {
        self::assertEquals('GetVariableIdWithSpaces', $identifier->toPascalCase('get'));
    }

    /** @depends testCreateFromString */
    public function testSnakeCase(Identifier $identifier): void
    {
        self::assertEquals('variable_id_with_spaces', $identifier->toSnakeCase());
    }

    /** @depends testCreateFromString */
    public function testSnakeCaseUpperCase(Identifier $identifier): void
    {
        self::assertEquals('VARIABLE_ID_WITH_SPACES', $identifier->toSnakeCase(toUpperCase: true));
    }

    /** @depends testCreateFromString */
    public function testSnakeCaseOriginalCase(Identifier $identifier): void
    {
        self::assertEquals('Variable_ID_with_spaces', $identifier->toSnakeCase(maintainCase: true));
    }

    /** @depends testCreateFromString */
    public function testKebabCase(Identifier $identifier): void
    {
        self::assertEquals('variable-id-with-spaces', $identifier->toKebabCase());
    }

    /** @depends testCreateFromString */
    public function testKebabCaseUpperCase(Identifier $identifier): void
    {
        self::assertEquals('VARIABLE-ID-WITH-SPACES', $identifier->toKebabCase(toUpperCase: true));
    }

    /** @depends testCreateFromString */
    public function testKebabCaseOriginalCase(Identifier $identifier): void
    {
        self::assertEquals('Variable-ID-with-spaces', $identifier->toKebabCase(maintainCase: true));
    }
}
