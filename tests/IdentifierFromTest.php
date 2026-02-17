<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\Identifiers\IdentifierMaker;

class IdentifierFromTest extends BaseTestClass
{
    public function testFromCamelCase(): void
    {
        $maker = new IdentifierMaker();
        $camelToKebab = $maker->fromCamelCase('fromCamelCase')->toKebabCase();

        self::assertEquals('from-camel-case', $camelToKebab);
    }
}
