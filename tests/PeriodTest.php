<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\{Exceptions\InvalidIso8601Duration, Period};

class PeriodTest extends BaseTestClass
{
    public function testRoundTrip(): void
    {
        self::assertSame('P1Y2M3DT4H5M6S', Period::fromString('P1Y2M3DT4H5M6S')->toString());
        self::assertSame('P1M', Period::fromString('P1M')->toString());
        self::assertSame('PT1M', Period::fromString('PT1M')->toString());
        self::assertSame('PT0S', Period::fromString('PT0S')->toString());
    }

    public function testOnlyTheDesignator(): void
    {
        $this->expectException(InvalidIso8601Duration::class);

        Period::fromString('P');
    }

    public function testOnlyTheTimeDesignator(): void
    {
        $this->expectException(InvalidIso8601Duration::class);

        Period::fromString('PT');
    }

    public function testTimeDesignatorWithoutTime(): void
    {
        $this->expectException(InvalidIso8601Duration::class);

        Period::fromString('P1DT');
    }
}
