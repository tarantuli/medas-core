<?php

declare(strict_types=1);

namespace Medas\CoreTest\Strings;

use Medas\Core\{CaseSensitiveString, StringMaker};
use Medas\CoreTest\BaseTestClass;

class StringMakerTests extends BaseTestClass
{
    public function testArray(): void
    {
        $string = StringMaker::instance()->fromVariable(['a', 'b']);

        self::assertEquals('["a", "b"]', $string);
    }

    public function testObject(): void
    {
        $string = StringMaker::instance()->fromVariable([new CaseSensitiveString('a')]);

        self::assertEquals('[Medas\Core\Stringo()]', $string);
    }

    public function testForceUtf8(): void
    {
        $string = StringMaker::instance()->fromVariable("ab\xa0\xa1cd", new StringMaker\Settings(forceUtf8: true));

        self::assertEquals('"ab▪a0▪a1cd"', $string);
    }
}
