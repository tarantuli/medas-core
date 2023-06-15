<?php

declare(strict_types=1);

namespace Medas\CoreTest\Strings;

use Medas\Core\{StringMaker, CaseSensitiveString};
use Medas\CoreTest\BaseTestClass;

class StringMakerTests extends BaseTestClass
{
    public function testArray(): void
    {
        $string = StringMaker::fromVariable(['a', 'b']);

        self::assertEquals('["a", "b"]', $string);
    }

    public function testObject(): void
    {
        $string = StringMaker::fromVariable([new CaseSensitiveString('a')]);

        self::assertEquals('[Medas\Core\Stringo()]', $string);
    }

    public function testForceUtf8(): void
    {
        $string = StringMaker::fromVariable("ab\xa0\xa1cd", forceUtf8: true);

        self::assertEquals('"ab▪a0▪a1cd"', $string);
    }
}
