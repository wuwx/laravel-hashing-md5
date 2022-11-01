<?php

namespace Wuwx\LaravelHashingMd5\Test;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class Md5HasherTest extends TestCase
{
    /** @test */
    public function testMd5Driver()
    {
        $this->assertEquals(Hash::driver('md5')->make("0"), "cfcd208495d565ef66e7dff9f98764da");
        $this->assertEquals(Hash::driver('md5')->make("123456"), "e10adc3949ba59abbe56e057f20f883e");
        $this->assertEquals(Hash::driver('md5')->make("admin"), "21232f297a57a5a743894a0e4a801fc3");
    }

    public function testDefaultDriver()
    {
        Config::set('hashing.driver', 'md5');
        $this->assertEquals(Hash::make("0"), "cfcd208495d565ef66e7dff9f98764da");
        $this->assertEquals(Hash::make("123456"), "e10adc3949ba59abbe56e057f20f883e");
        $this->assertEquals(Hash::make("admin"), "21232f297a57a5a743894a0e4a801fc3");
    }
}