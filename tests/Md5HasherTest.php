<?php

namespace Wuwx\LaravelHashingMd5\Test;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class Md5HasherTest extends TestCase
{
    public function testMd5Driver(): void
    {
        $this->assertSame('cfcd208495d565ef66e7dff9f98764da', Hash::driver('md5')->make('0'));
        $this->assertSame('e10adc3949ba59abbe56e057f20f883e', Hash::driver('md5')->make('123456'));
        $this->assertSame('21232f297a57a5a743894a0e4a801fc3', Hash::driver('md5')->make('admin'));
    }

    public function testDefaultDriver(): void
    {
        Config::set('hashing.driver', 'md5');

        $this->assertSame('cfcd208495d565ef66e7dff9f98764da', Hash::make('0'));
        $this->assertSame('e10adc3949ba59abbe56e057f20f883e', Hash::make('123456'));
        $this->assertSame('21232f297a57a5a743894a0e4a801fc3', Hash::make('admin'));
    }

    public function testCheck(): void
    {
        $hasher = Hash::driver('md5');

        $this->assertTrue($hasher->check('password', $hasher->make('password')));
        $this->assertFalse($hasher->check('password', $hasher->make('wrong-password')));
    }

    public function testCheckWithEmptyHash(): void
    {
        $this->assertFalse(Hash::driver('md5')->check('password', ''));
    }

    public function testNeedsRehash(): void
    {
        $this->assertFalse(Hash::driver('md5')->needsRehash('e10adc3949ba59abbe56e057f20f883e'));
    }

    public function testInfo(): void
    {
        $info = Hash::driver('md5')->info('e10adc3949ba59abbe56e057f20f883e');

        $this->assertNull($info['algo']);
        $this->assertSame('unknown', $info['algoName']);
    }
}
