<?php

declare(strict_types=1);

namespace Medas\CoreTest\Strings;

use Medas\Core\{CaseInsensitiveString, CaseSensitiveString};
use Medas\CoreTest\BaseTestClass;

class StringTest extends BaseTestClass
{
    private const TEST_STRING = 'aaabbbccc';

    public function testStartsWith(): void
    {
        self::assertTrue($this->getCaseSensitiveString()->startsWith('aaab'));
        self::assertFalse($this->getCaseSensitiveString()->startsWith('aaaB'));

        self::assertTrue($this->getCaseInsensitiveString()->startsWith('aaab'));
        self::assertTrue($this->getCaseInsensitiveString()->startsWith('aaaB'));
    }

    private function getCaseSensitiveString(): CaseSensitiveString
    {
        return new CaseSensitiveString(self::TEST_STRING);
    }

    private function getCaseInsensitiveString(): CaseSensitiveString
    {
        return new CaseInsensitiveString(self::TEST_STRING);
    }

    public function testChopFromStart(): void
    {
        $string = $this->getCaseSensitiveString();
        self::assertTrue($string->chopFromStart('aaab'));
        self::assertEquals('bbccc', (string) $string);

        $string = $this->getCaseSensitiveString();
        self::assertFalse($string->chopFromStart('aaaB'));
        self::assertEquals(self::TEST_STRING, (string) $string);

        $string = $this->getCaseInsensitiveString();
        self::assertTrue($string->chopFromStart('aaab'));
        self::assertEquals('bbccc', (string) $string);

        $string = $this->getCaseInsensitiveString();
        self::assertTrue($string->chopFromStart('aaaB'));
        self::assertEquals('bbccc', (string) $string);
    }
}
