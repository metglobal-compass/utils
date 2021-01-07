<?php

namespace Metglobal\Utils\Tests;

use Metglobal\Utils\Optional;
use Metglobal\Utils\Tests\Fixtures\DummyOptional;
use PHPUnit\Framework\TestCase;

class OptionalTest extends TestCase
{
    public function testValueIsPresent()
    {
        $object = new class {};
        $object->foo = 'bar';

        $this->assertEquals('bar', (new Optional($object))->foo);
        $this->assertEquals('bar', \optional($object)->foo);
    }

    public function testValueIsNotPresent()
    {
        $object = null;

        $this->assertNull((new Optional($object))->foo);
        $this->assertNull(\optional($object)->foo);
        $this->assertNull(\optional($object)->present()->foo);
    }

    public function testValueMethodIsPresent()
    {
        $object = new DummyOptional();
        $object->setFoo('bar');
        $object->setBaz(false);

        $this->assertEquals('bar', (new Optional($object))->getFoo());
        $this->assertEquals(false, \optional($object)->getBaz());
    }

    public function testValueMethodIsNotPresent()
    {
        $object = null;

        $this->assertNull((new Optional($object))->getFoo());
        $this->assertNull(\optional($object)->getFoo());
        $this->assertNull(\optional($object)->present()->getFoo());
    }
}