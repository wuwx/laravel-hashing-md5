<?php

namespace Wuwx\LaravelHashingMd5\Test;

use Illuminate\Database\Eloquent\Model;
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

    public function testMakeCastsNonStringValueToString(): void
    {
        $this->assertSame(md5('123456'), Hash::driver('md5')->make(123456));
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

    public function testCheckWithUppercaseHash(): void
    {
        $this->assertTrue(Hash::driver('md5')->check('123456', strtoupper(md5('123456'))));
    }

    public function testCheckWithEmptyHash(): void
    {
        $this->assertFalse(Hash::driver('md5')->check('password', ''));
    }

    public function testCheckWithNullHash(): void
    {
        $this->assertFalse(Hash::driver('md5')->check('password', null));
    }

    public function testNeedsRehash(): void
    {
        $this->assertFalse(Hash::driver('md5')->needsRehash('e10adc3949ba59abbe56e057f20f883e'));
    }

    public function testVerifyConfiguration(): void
    {
        $this->assertTrue(Hash::driver('md5')->verifyConfiguration([]));
    }

    public function testInfo(): void
    {
        $hasher = Hash::driver('md5');

        $info = $hasher->info('e10adc3949ba59abbe56e057f20f883e');
        $this->assertSame('md5', $info['algo']);
        $this->assertSame('md5', $info['algoName']);

        $info = $hasher->info('not-a-hash');
        $this->assertNull($info['algo']);
        $this->assertSame('unknown', $info['algoName']);
    }

    public function testIsHashed(): void
    {
        if (version_compare($this->app->version(), '11.0.0', '<')) {
            $this->markTestSkipped('Laravel 10 的 Hash::isHashed() 硬编码 password_get_info()，不识别自定义驱动生成的哈希');
        }

        Config::set('hashing.driver', 'md5');

        $this->assertTrue(Hash::isHashed(md5('secret')));
        $this->assertFalse(Hash::isHashed('secret'));
    }

    public function testHashedCastKeepsPreHashedValue(): void
    {
        if (version_compare($this->app->version(), '11.0.0', '<')) {
            $this->markTestSkipped('Laravel 10 的 hashed cast 依赖硬编码 password_get_info() 的 isHashed()，无法识别自定义驱动的哈希');
        }

        Config::set('hashing.driver', 'md5');

        $model = new class extends Model
        {
            protected $casts = ['password' => 'hashed'];
        };

        // 明文密码：cast 应哈希后入库
        $model->password = 'secret';
        $this->assertSame(md5('secret'), $model->getAttributes()['password']);

        // 已是 MD5 哈希的值（数据导入等场景）：应保持原值，不得二次哈希
        $hashed = md5('another-secret');
        $model->password = $hashed;
        $this->assertSame($hashed, $model->getAttributes()['password']);
    }
}
