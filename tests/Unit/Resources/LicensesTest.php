<?php

use Creem\Resources\Licenses;
use Creem\Data\Entities\LicenseEntity;
use Creem\Data\Requests\ActivateLicenseRequest;
use Creem\Data\Requests\DeactivateLicenseRequest;
use Creem\Data\Requests\ValidateLicenseRequest;
use Creem\Http\HttpClient;
use Mockery;

test('licenses resource can activate license', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/licenses/activate', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'lic_123',
            'mode' => 'test',
            'object' => 'license',
            'status' => 'active',
            'key' => 'XXXX-XXXX-XXXX-XXXX',
            'activation' => 1,
            'created_at' => '2024-01-01T00:00:00Z',
        ]);

    $licenses = new Licenses($httpClient);
    $request = new ActivateLicenseRequest(
        key: 'XXXX-XXXX-XXXX-XXXX',
        instanceName: 'My Device',
    );
    $license = $licenses->activate($request);

    expect($license)->toBeInstanceOf(LicenseEntity::class);
    expect($license->key)->toBe('XXXX-XXXX-XXXX-XXXX');
});

test('licenses resource can deactivate license', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/licenses/deactivate', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'lic_123',
            'mode' => 'test',
            'object' => 'license',
            'status' => 'inactive',
            'key' => 'XXXX-XXXX-XXXX-XXXX',
            'activation' => 0,
            'created_at' => '2024-01-01T00:00:00Z',
        ]);

    $licenses = new Licenses($httpClient);
    $request = new DeactivateLicenseRequest(
        key: 'XXXX-XXXX-XXXX-XXXX',
        instanceId: 'inst_123',
    );
    $license = $licenses->deactivate($request);

    expect($license)->toBeInstanceOf(LicenseEntity::class);
    expect($license->status->value)->toBe('inactive');
});

test('licenses resource can validate license', function () {
    $httpClient = Mockery::mock(HttpClient::class);
    $httpClient->shouldReceive('post')
        ->with('/v1/licenses/validate', Mockery::any())
        ->once()
        ->andReturn([
            'id' => 'lic_123',
            'mode' => 'test',
            'object' => 'license',
            'status' => 'active',
            'key' => 'XXXX-XXXX-XXXX-XXXX',
            'activation' => 1,
            'created_at' => '2024-01-01T00:00:00Z',
        ]);

    $licenses = new Licenses($httpClient);
    $request = new ValidateLicenseRequest(key: 'XXXX-XXXX-XXXX-XXXX');
    $license = $licenses->validate($request);

    expect($license)->toBeInstanceOf(LicenseEntity::class);
    expect($license->status->value)->toBe('active');
});

afterEach(function () {
    Mockery::close();
});
