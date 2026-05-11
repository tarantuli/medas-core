<?php

declare(strict_types=1);

namespace Medas\CoreTest\Collections;

use Medas\Core\Collections\GenericCollection;
use PHPUnit\Framework\TestCase;

class GenericCollectionTest extends TestCase
{
    public function testAdditions(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();
        $c = new \stdClass();
        $collection = new GenericCollection([$a, $b]);
        $collection[] = $c;

        self::assertEquals([2 => $c], iterator_to_array($collection->getAdditions()));
        self::assertEquals([], iterator_to_array($collection->getDeletions()));
        self::assertEquals([], iterator_to_array($collection->getModifications()));
    }

    public function testDeletions(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();
        $c = new \stdClass();
        $collection = new GenericCollection([$a, $b, $c]);

        unset($collection[1]);

        self::assertEquals([], iterator_to_array($collection->getAdditions()));
        self::assertEquals([1 => $b], iterator_to_array($collection->getDeletions()));
        self::assertEquals([], iterator_to_array($collection->getModifications()));
    }

    public function testModifications(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();
        $c = new \stdClass();
        $collection = new GenericCollection([$a, $b, $c]);
        $collection[0] = $b;
        $collection[1] = $c;
        $collection[2] = $a;

        self::assertEquals([], iterator_to_array($collection->getAdditions()));
        self::assertEquals([], iterator_to_array($collection->getDeletions()));
        self::assertEquals([$b, $c, $a], iterator_to_array($collection->getModifications()));
    }

    public function testModifications2(): void
    {
        $a = new \stdClass();
        $b = new \stdClass();
        $c = new \stdClass();
        $collection = new GenericCollection([$a, $b, $c]);
        $collection[1] = $c;
        $collection[2] = $b;

        self::assertEquals([], iterator_to_array($collection->getAdditions()));
        self::assertEquals([], iterator_to_array($collection->getDeletions()));
        self::assertEquals([1 => $c, 2 => $b], iterator_to_array($collection->getModifications()));
    }
}
