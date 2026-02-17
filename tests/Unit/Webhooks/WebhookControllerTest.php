<?php

use Creem\Webhooks\WebhookController;
use Creem\Webhooks\WebhookHandler;
use Illuminate\Http\Request;
use Mockery;

test('webhook controller returns 200 on success', function () {
    $handler = Mockery::mock(WebhookHandler::class);
    $handler->shouldReceive('handle')->once();

    $controller = new WebhookController($handler);
    
    $request = Request::create('/webhooks/creem', 'POST', [
        'event_type' => 'checkout.completed',
        'object' => 'event',
        'data' => ['id' => 'ch_123'],
    ]);
    $request->headers->set('X-Creem-Signature', 'test_signature');

    config(['creem.webhook.secret' => 'test_secret']);

    $response = $controller->handle($request);

    expect($response->getStatusCode())->toBe(200);
    expect($response->getContent())->toBe('OK');
});

test('webhook controller returns 400 on error', function () {
    $handler = Mockery::mock(WebhookHandler::class);
    $handler->shouldReceive('handle')->andThrow(new \Exception('Invalid signature'));

    $controller = new WebhookController($handler);
    
    $request = Request::create('/webhooks/creem', 'POST', [
        'event_type' => 'test',
        'object' => 'event',
        'data' => [],
    ]);
    $request->headers->set('X-Creem-Signature', 'invalid');

    config(['creem.webhook.secret' => 'test_secret']);

    $response = $controller->handle($request);

    expect($response->getStatusCode())->toBe(400);
    expect($response->getContent())->toBe('Invalid signature');
});

test('webhook controller gets signature from header', function () {
    $handler = Mockery::mock(WebhookHandler::class);
    $handler->shouldReceive('handle')
        ->with(Mockery::any(), Mockery::any(), 'custom_sig_value', Mockery::any())
        ->once();

    $controller = new WebhookController($handler);
    
    $request = Request::create('/webhooks/creem', 'POST', [
        'event_type' => 'test',
        'object' => 'event',
        'data' => [],
    ]);
    $request->headers->set('X-Creem-Signature', 'custom_sig_value');

    config(['creem.webhook.secret' => 'secret']);

    $controller->handle($request);
});

afterEach(function () {
    Mockery::close();
});
