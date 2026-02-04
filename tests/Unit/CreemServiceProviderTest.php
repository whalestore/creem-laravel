<?php

use Creem\CreemServiceProvider;
use Creem\Creem;
use Illuminate\Support\Facades\Config;

test('service provider registers creem singleton', function () {
    $this->app->register(CreemServiceProvider::class);

    expect($this->app->bound(Creem::class))->toBeTrue();
});

test('service provider configures creem from config', function () {
    Config::set('creem.api_key', 'config_api_key');
    Config::set('creem.environment', 'sandbox');

    $this->app->register(CreemServiceProvider::class);

    $creem = $this->app->make(Creem::class);

    expect($creem)->toBeInstanceOf(Creem::class);
});

test('service provider merges config', function () {
    $this->app->register(CreemServiceProvider::class);

    $config = Config::get('creem');

    expect($config)->toHaveKey('api_key');
    expect($config)->toHaveKey('environment');
    expect($config)->toHaveKey('webhook');
    expect($config)->toHaveKey('retry');
});

test('service provider creates creem alias', function () {
    $this->app->register(CreemServiceProvider::class);

    expect($this->app->isAlias('creem'))->toBeTrue();
});
