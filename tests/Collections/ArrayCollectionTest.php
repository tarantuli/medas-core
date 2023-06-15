<?php

declare(strict_types=1);

namespace Medas\CoreTest\Collections;

use Medas\Core\Collections\ArrayCollection;
use Medas\CoreTest\BaseTestClass;

class ArrayCollectionTest extends BaseTestClass
{
    public function testCreation(): ArrayCollection
    {
        $collection = new ArrayCollection();

        $collection->add(1, 10);
        $collection->add(2, 20);
        $collection->add(2, 30);
        $collection->add(3, 40);

        self::assertInstanceOf(ArrayCollection::class, $collection);

        return $collection;
    }

    /** @depends testCreation */
    public function testAtIndex(ArrayCollection $collection): void
    {
        self::assertEquals([20, 30], $collection->atIndex(2));
    }

    /** @depends testCreation */
    public function testAtMaxIndex(ArrayCollection $collection): void
    {
        self::assertEquals([40], $collection->atMaxIndex());
    }

    /** @depends testCreation */
    public function testAtMinIndex(ArrayCollection $collection): void
    {
        self::assertEquals([10], $collection->atMinIndex());
    }

    /** @depends testCreation */
    public function testAtMaxCount(ArrayCollection $collection): void
    {
        self::assertEquals([20, 30], $collection->atMaxCount());
    }

    /** @depends testCreation */
    public function testAtMinCount(ArrayCollection $collection): void
    {
        self::assertEquals([10], $collection->atMinCount());
    }

    /** @depends testCreation */
    public function testIndexes(ArrayCollection $collection): void
    {
        self::assertEquals([1, 2, 3], $collection->indexes());
    }
}
