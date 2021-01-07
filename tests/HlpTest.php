<?php

namespace Metglobal\Utils\Tests;

use Metglobal\Utils\Hlp;
use Metglobal\Utils\Tests\Fixtures\DummyHlp;
use PHPUnit\Framework\TestCase;

class HlpTest extends TestCase
{
    public function testClassBasename()
    {
        $this->assertEquals('DummyHlp', Hlp::classBasename(DummyHlp::class));
        $this->assertEquals('DummyHlp', class_basename(DummyHlp::class));
        $this->assertEquals('DummyHlp', class_basename(new DummyHlp()));
        $this->assertNotEquals('DummyHlp', class_basename(new \stdClass()));
        $this->assertNotEquals(
            'DummyHlp',
            class_basename(
                new class {
                }
            )
        );
    }
}