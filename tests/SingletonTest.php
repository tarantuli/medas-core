<?php

declare(strict_types=1);

namespace Medas\CoreTest;

use Medas\Core\{Exceptions\CannotInstantiateClassWithParameters, SingletonStore};
use Medas\CoreTest\MockUps\{OptionalParameters, RequiredParameters, SingletonChild, SingletonParent};

class SingletonTest extends BaseTestClass
{
    public function testAsSingletonReturnsTheSameInstance(): void
    {
        self::assertSame(SingletonParent::instance(), SingletonParent::instance());
    }

    public function testSubclassGetsItsOwnInstance(): void
    {
        self::assertSame(SingletonChild::class, SingletonChild::instance()::class);
        self::assertSame(SingletonParent::class, SingletonParent::instance()::class);
        self::assertSame(SingletonChild::instance(), SingletonChild::instance());
    }

    public function testStoreWithOptionalParameters(): void
    {
        $object = SingletonStore::get(OptionalParameters::class);

        self::assertSame(1, $object->value);
        self::assertSame($object, SingletonStore::get(OptionalParameters::class));
    }

    public function testStoreWithRequiredParameters(): void
    {
        $this->expectException(CannotInstantiateClassWithParameters::class);

        SingletonStore::get(RequiredParameters::class);
    }
}
