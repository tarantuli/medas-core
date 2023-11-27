<?php

declare(strict_types=1);

use Medas\CoreTest\BaseTestClass;

class WhileTrueTest extends BaseTestClass
{
    public function testDefaultCounter(): void
    {
        $localCounter = 0;

        whileTrue(function () use (&$localCounter) {
            ++$localCounter;
            return true;
        });

        self::assertEquals(256, $localCounter);
    }

    public function testGivenCounter(): void
    {
        $localCounter = 0;

        whileTrue(function () use (&$localCounter) {
            ++$localCounter;
            return true;
        }, 10);

        self::assertEquals(10, $localCounter);
    }
}
