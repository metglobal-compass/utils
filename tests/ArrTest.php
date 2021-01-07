<?php

namespace Metglobal\Utils\Tests;

use Metglobal\Utils\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function testExists()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertTrue(Arr::exists($array, 'foo'));
        $this->assertFalse(Arr::exists($array, 'invalid'));
    }

    public function testExcept()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertSame(['bar' => 'baz'], Arr::except($array, 'foo'));
        $this->assertSame(['foo' => true, 'bar' => 'baz'], Arr::except($array, 'invalid'));
    }

    public function testFirst()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertSame(null, Arr::first([]));
        $this->assertSame(true, Arr::first($array));
        $this->assertSame(
            'baz',
            Arr::first($array, function ($value, $key) {
                return 'baz' === $value;
            })
        );
        $this->assertSame(
            'baz',
            Arr::first($array, function ($value, $key) {
                return 'bar' === $key;
            })
        );
    }

    public function testLast()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertSame(null, Arr::last([]));
        $this->assertSame('baz', Arr::last($array));
        $this->assertSame(
            'baz',
            Arr::last($array, function ($value, $key) {
                return 'baz' === $value;
            })
        );
        $this->assertSame(
            true,
            Arr::last($array, function ($value, $key) {
                return 'foo' === $key;
            })
        );
    }

    public function testGet()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertSame(null, Arr::get([$array], 'invalid'));
        $this->assertSame(true, Arr::get($array, 'foo'));
    }

    public function testForget()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        Arr::forget($array, 'foo');

        $this->assertSame(['bar' => 'baz'], $array);
    }

    public function testHas()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertTrue(Arr::has($array, 'foo'));
        $this->assertTrue(Arr::has($array, ['foo', 'bar']));
        $this->assertFalse(Arr::has($array, 'invalid'));
    }

    public function testAssoc()
    {
        $array = ['foo' => true, 'bar' => 'baz'];
        $nonAssocArray = [true, 'baz'];

        $this->assertTrue(Arr::assoc($array));
        $this->assertFalse(Arr::assoc($nonAssocArray));
    }

    public function testOnly()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $this->assertSame(['foo' => true], Arr::only($array, 'foo'));
        $this->assertSame(['foo' => true, 'bar' => 'baz'], Arr::only($array, ['foo', 'bar']));
    }

    public function testDot()
    {
        $array = ['foo' => true, 'bar' => ['baz' => 'baz']];

        $this->assertSame(['foo' => true, 'bar.baz' => 'baz'], Arr::dot($array));
    }

    public function testPrepend()
    {
        $array = ['bar' => 'baz'];

        $this->assertSame(['foo' => true, 'bar' => 'baz'], Arr::prepend($array, true, 'foo'));
    }

    public function testPull()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $value = Arr::pull($array, 'foo');

        $this->assertSame(true, $value);
        $this->assertSame(['bar' => 'baz'], $array);
    }

    public function testRandom()
    {
        $array = ['foo' => true, 'bar' => 'baz'];

        $value = Arr::random($array);

        $this->assertFalse(is_array($value));

        $value = Arr::random($array, 2);

        $this->assertSame([true, 'baz'], $value);

        $value = Arr::random($array, 2, true);

        $this->assertSame($array, $value);
    }

    public function testSet()
    {
        $array = ['foo' => true];

        Arr::set($array, 'bar.baz', 'baz');

        $this->assertSame(['foo' => true, 'bar' => ['baz' => 'baz']], $array);
    }

    // TODO: add more tests...
}