<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\Identifier;

class IdentifierFromTest extends BaseTestClass
{
    public function testFromCamelCase(): void
    {
        $identifier = new Identifier('fromCamelCase');
        $camelToKebab = $identifier->toKebabCase();

        self::assertEquals('from-camel-case', $camelToKebab);
    }
}
