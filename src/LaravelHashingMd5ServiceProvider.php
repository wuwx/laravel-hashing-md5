<?php
namespace Wuwx\LaravelHashingMd5;

use Illuminate\Support\ServiceProvider;

class LaravelHashingMd5ServiceProvider extends ServiceProvider
{
    public function boot()
    {
        app('hash')->extend('md5', function () {
            return new Md5Hasher();
        });
    }
}
