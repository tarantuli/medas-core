<?php

declare(strict_types=1);

namespace Medas\CoreTest\Strings;

use Medas\Core\{FloatingNumber, StringMaker};
use Medas\CoreTest\BaseTestClass;

class StringMakerTest extends BaseTestClass
{
    public function testArray(): void
    {
        $string = StringMaker::instance()->fromVariable(['a', 'b']);

        self::assertEquals('["a", "b"]', $string);
    }

    public function testObject(): void
    {
        $string = StringMaker::instance()->fromVariable([new FloatingNumber()]);
        $string = preg_replace('/\d+/', '###', $string);

        self::assertEquals('[Medas\Core\FloatingNumber[###]()]', $string);
    }

    public function testForceUtf8(): void
    {
        $string = StringMaker::instance()->fromVariable(
            "ab\xa0\xa1cddddddddcddddddddcddddddddcddddddddcdddddddd",
            new StringMaker\Settings(forceUtf8: true)
        );

        self::assertEquals('"ab▪a0▪a1cddddddddcddddddddcddddddddcddddddddcdddddddd"', $string);
    }

    public function testForceBinary(): void
    {
        $string = StringMaker::instance()->fromVariable(
            "ab\xa0\xa1cd",
            new StringMaker\Settings(forceUtf8: true)
        );

        self::assertEquals('0x226162a0a1636422', $string);
    }
}
