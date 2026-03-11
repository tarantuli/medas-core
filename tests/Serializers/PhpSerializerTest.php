<?php

declare(strict_types=1);

namespace Medas\CoreTest\Serializers;

use Medas\Core\Serializers\PhpSerializer;
use PHPUnit\Framework\TestCase;

class PhpSerializerTest extends TestCase
{
    public function testClosure(): void
    {
        $object = new TestClass2();
        $serializer = new PhpSerializer();

        self::expectExceptionMessage('found a closure at Medas\CoreTest\Serializers\TestClass2::testClass → Medas\CoreTest\Serializers\TestClass::myClosure');

        $serializer->serialize($object);
    }
}

class TestClass
{
    private \Closure $myClosure;

    public function __construct()
    {
        $this->myClosure = function () {
        };
    }
}

class TestClass2
{
    public function __construct(private TestClass $testClass = new TestClass())
    {
    }
}
