<?php

namespace Creem\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Creem\CreemServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            CreemServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Creem' => \Creem\Facades\Creem::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('creem.api_key', 'test_api_key');
        $app['config']->set('creem.environment', 'test');
    }
}
