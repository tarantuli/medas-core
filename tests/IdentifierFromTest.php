<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\Identifier;

class IdentifierFromTest extends BaseTestClass
{
    public function testFromCamelCase(): void
    {
        $camelToKebab = Identifier::fromCamelCase('fromCamelCase')->toKebabCase();

        self::assertEquals('from-camel-case', $camelToKebab);
    }
}
