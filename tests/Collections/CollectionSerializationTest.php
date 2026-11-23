<?php

declare(strict_types=1);

namespace Medas\CoreTest\Collections;

use Medas\Core\{
    Collections\GenericCollection,
    Collections\LazyGenericCollection,
    Exceptions\CannotSerializeUnloadedLazyCollection
};
use PHPUnit\Framework\TestCase;

class CollectionSerializationTest extends TestCase
{
    public function testACopyKeepsTheBaseline(): void
    {
        $stored = new \stdClass();
        $added = new \stdClass();
        $collection = new GenericCollection();
        $collection->setData([$stored]);
        $collection[] = $added;

        $copy = unserialize(serialize($collection));

        self::assertTrue($copy->hasChanged());
        self::assertCount(1, iterator_to_array($copy->getAdditions()));
        self::assertSame([], iterator_to_array($copy->getDeletions()));
    }

    public function testACopyOfAnUnchangedCollectionIsUnchanged(): void
    {
        $collection = new GenericCollection();
        $collection->setData([new \stdClass()]);

        self::assertFalse(unserialize(serialize($collection))->hasChanged());
    }

    public function testAnUnloadedLazyCollectionCannotBeSerialized(): void
    {
        $collection = new LazyGenericCollection();
        $collection->setLoader(fn() => [new \stdClass()]);

        $this->expectException(CannotSerializeUnloadedLazyCollection::class);

        serialize($collection);
    }

    public function testALoadedLazyCollectionCanBeSerialized(): void
    {
        $collection = new LazyGenericCollection();
        $collection->setLoader(fn() => [new \stdClass()]);

        self::assertCount(1, $collection);

        $copy = unserialize(serialize($collection));

        self::assertCount(1, $copy);
        self::assertFalse($copy->hasChanged());
    }
}
