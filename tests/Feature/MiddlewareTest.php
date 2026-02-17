<?php

namespace Creem\Tests\Feature;

use Creem\Creem;
use Creem\Http\HttpClient;
use Creem\Http\Middleware\EnsureSubscribed;
use Creem\Tests\TestCase;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Mockery;

class MiddlewareTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);
        $app['config']->set('creem.subscription.redirect', '/subscribe');
        $app['config']->set('creem.subscription.login_redirect', '/login');
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function createTestUser(): object
    {
        return new class extends Authenticatable {
            public $id = 1;

            public function getKey()
            {
                return $this->id;
            }
        };
    }

    protected function createMockedMiddleware(array $subscriptionResponse): EnsureSubscribed
    {
        $mockHttpClient = Mockery::mock(HttpClient::class);
        $mockHttpClient->shouldReceive('get')
            ->with('/v1/subscriptions', Mockery::any())
            ->andReturn($subscriptionResponse);

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->shouldReceive('getClient')->andReturn($mockHttpClient);

        return new EnsureSubscribed($mockCreem);
    }

    public function test_middleware_allows_subscribed_users()
    {
        $middleware = $this->createMockedMiddleware([
            'items' => [
                [
                    'id' => 'sub_123',
                    'status' => 'active',
                    'product_id' => 'prod_premium',
                ],
            ],
        ]);

        $request = Request::create('/protected', 'GET');
        $request->setUserResolver(fn() => $this->createTestUser());

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals('OK', $response->getContent());
    }

    public function test_middleware_blocks_unsubscribed_users()
    {
        $middleware = $this->createMockedMiddleware([
            'items' => [],
        ]);

        $request = Request::create('/protected', 'GET');
        $request->setUserResolver(fn() => $this->createTestUser());

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertTrue($response->isRedirect());
        $this->assertStringContainsString('/subscribe', $response->getTargetUrl());
    }

    public function test_middleware_returns_json_for_api_requests()
    {
        $middleware = $this->createMockedMiddleware([
            'items' => [],
        ]);

        $request = Request::create('/api/protected', 'GET');
        $request->headers->set('Accept', 'application/json');
        $request->setUserResolver(fn() => $this->createTestUser());

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(403, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function test_middleware_redirects_unauthenticated_users()
    {
        // No need to mock API for unauthenticated users
        $mockCreem = Mockery::mock(Creem::class);
        $middleware = new EnsureSubscribed($mockCreem);

        $request = Request::create('/protected', 'GET');
        $request->setUserResolver(fn() => null);

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertTrue($response->isRedirect());
    }

    public function test_middleware_checks_specific_plan()
    {
        $middleware = $this->createMockedMiddleware([
            'items' => [
                [
                    'id' => 'sub_123',
                    'status' => 'active',
                    'product_id' => 'prod_basic',
                ],
            ],
        ]);

        $request = Request::create('/protected', 'GET');
        $request->setUserResolver(fn() => $this->createTestUser());

        // User has basic, but route requires premium
        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        }, 'prod_premium');

        $this->assertTrue($response->isRedirect());
    }

    public function test_middleware_allows_matching_plan()
    {
        $middleware = $this->createMockedMiddleware([
            'items' => [
                [
                    'id' => 'sub_123',
                    'status' => 'active',
                    'product_id' => 'prod_premium',
                ],
            ],
        ]);

        $request = Request::create('/protected', 'GET');
        $request->setUserResolver(fn() => $this->createTestUser());

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        }, 'prod_premium');

        $this->assertEquals('OK', $response->getContent());
    }
}
