<?php

namespace Metglobal\Utils\Tests;

use Metglobal\Utils\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function testSort()
    {
        $collection = new Collection(['foo' => true, 'bar' => 'baz']);

        $sortedCollection = $collection->sort();

        $this->assertSame(['foo' => true, 'bar' => 'baz'], $sortedCollection->all());

        $sortedCollection = $collection->sort(
            function ($a, $b) {
                return $a <=> $b;
            }
        );

        $this->assertSame(['foo' => true, 'bar' => 'baz'], $sortedCollection->all());
    }

    public function testSortKeys()
    {
        $collection = new Collection(['foo' => true, 'bar' => 'baz']);

        $sortedCollection = $collection->sortKeys();

        $this->assertSame(['bar' => 'baz', 'foo' => true], $sortedCollection->all());
    }

    public function testRange()
    {
        $rangeCollection = (new Collection())->range(1, 9);

        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8, 9], $rangeCollection->all());
    }

    public function testAll()
    {
        $collection = new Collection(['foo' => true, 'bar' => 'baz']);

        $this->assertSame(['foo' => true, 'bar' => 'baz'], $collection->all());
    }

    public function testKeys()
    {
        $collection = new Collection(['foo' => true, 'bar' => 'baz']);

        $keysCollection = $collection->keys();

        $this->assertSame(['foo', 'bar'], $keysCollection->all());
    }

    public function testContains()
    {
        $collection = new Collection(['foo', 'bar', 'baz']);

        $this->assertTrue($collection->contains('foo'));
        $this->assertNotTrue($collection->contains('invalid'));
    }

    // TODO: add more tests
}
