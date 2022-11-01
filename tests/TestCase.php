<?php

namespace Wuwx\LaravelHashingMd5\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Wuwx\LaravelHashingMd5\LaravelHashingMd5ServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelHashingMd5ServiceProvider::class,
        ];
    }
}