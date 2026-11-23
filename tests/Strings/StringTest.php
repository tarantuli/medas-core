<?php

declare(strict_types=1);

namespace Medas\CoreTest\Strings;

use Medas\Core\{
    CaseInsensitiveString,
    CaseSensitiveString,
    Exceptions\ChopStringCannotBeEmpty,
    Exceptions\TruncationLengthTooShort
};
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

    public function testChopFromStart(): void
    {
        $string = $this->getCaseSensitiveString();
        $string = $string->chopFromStart('aaab');

        self::assertEquals('bbccc', (string) $string);

        $string = $this->getCaseSensitiveString();
        $string = $string->chopFromStart('aaaB');

        self::assertEquals(self::TEST_STRING, (string) $string);

        $string = $this->getCaseInsensitiveString();
        $string = $string->chopFromStart('aaab');

        self::assertEquals('bbccc', (string) $string);

        $string = $this->getCaseInsensitiveString();
        $string = $string->chopFromStart('aaaB');

        self::assertEquals('bbccc', (string) $string);
    }

    public function testChopFromStartWithEmptyString(): void
    {
        $this->expectException(ChopStringCannotBeEmpty::class);

        $this->getCaseSensitiveString()->chopFromStart('');
    }

    public function testChopFromEndWithEmptyString(): void
    {
        $this->expectException(ChopStringCannotBeEmpty::class);

        $this->getCaseSensitiveString()->chopFromEnd('');
    }

    public function testTruncateToByteLength(): void
    {
        self::assertSame('a…', (string) $this->getCaseSensitiveString()->truncateToByteLength(4));
        self::assertSame(self::TEST_STRING, (string) $this->getCaseSensitiveString()->truncateToByteLength(9));
    }

    public function testTruncateToByteLengthTooShort(): void
    {
        $this->expectException(TruncationLengthTooShort::class);

        $this->getCaseSensitiveString()->truncateToByteLength(3);
    }

    public function testTruncateToCharLength(): void
    {
        self::assertSame('aaa…', (string) $this->getCaseSensitiveString()->truncateToCharLength(4));
        self::assertSame(self::TEST_STRING, (string) $this->getCaseSensitiveString()->truncateToCharLength(9));
    }

    public function testTruncateToCharLengthTooShort(): void
    {
        $this->expectException(TruncationLengthTooShort::class);

        $this->getCaseSensitiveString()->truncateToCharLength(3);
    }

    private function getCaseSensitiveString(): CaseSensitiveString
    {
        return new CaseSensitiveString(self::TEST_STRING);
    }

    private function getCaseInsensitiveString(): CaseSensitiveString
    {
        return new CaseInsensitiveString(self::TEST_STRING);
    }
}
