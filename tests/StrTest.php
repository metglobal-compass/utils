<?php

namespace Metglobal\Utils\Tests;

use Metglobal\Utils\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testInterpolate()
    {
        $this->assertSame(
            'User bolivar created',
            Str::interpolate('User {username} created', ['username' => 'bolivar'])
        );
        $this->assertSame(
            'User bolivar created for bolivar',
            str_interpolate('User {username} created for {username}', ['username' => 'bolivar'])
        );
    }

    public function testRandom()
    {
        $this->assertEquals(8, strlen(Str::random()));
        $this->assertEquals(40, strlen(Str::random(40)));
        $this->assertNotEquals(Str::random(), Str::random());
        $this->assertNotEquals(str_random(), str_random());
    }
}
