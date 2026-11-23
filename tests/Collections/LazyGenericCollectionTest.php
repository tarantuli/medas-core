<?php

declare(strict_types=1);

namespace Medas\CoreTest\Collections;

use Medas\Core\Collections\LazyGenericCollection;
use PHPUnit\Framework\TestCase;

class LazyGenericCollectionTest extends TestCase
{
    public function testNewItemsCountAsChangedWithoutBeingRead(): void
    {
        $collection = new LazyGenericCollection(fn() => [new \stdClass()]);

        self::assertTrue($collection->hasChanged());
    }

    public function testStoredItemsAreNotLoadedToCheckForChanges(): void
    {
        $loaded = false;
        $collection = new LazyGenericCollection();

        $collection->setLoader(function () use (&$loaded): array {
            $loaded = true;

            return [new \stdClass()];
        });

        self::assertFalse($collection->hasChanged());
        self::assertFalse($loaded);
    }
}
