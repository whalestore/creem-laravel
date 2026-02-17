<?php

namespace Creem\Tests\Feature;

use Creem\Creem;
use Creem\Data\Entities\CheckoutEntity;
use Creem\Data\Requests\CreateCheckoutRequest;
use Creem\Resources\Checkouts;
use Creem\Tests\TestCase;
use Mockery;

class CheckoutTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function getCheckoutData(array $overrides = []): array
    {
        return array_merge([
            'id' => 'checkout_test123',
            'mode' => 'prod',
            'object' => 'checkout',
            'status' => 'pending',
            'checkout_url' => 'https://checkout.creem.io/test123',
        ], $overrides);
    }

    public function test_can_create_checkout()
    {
        $checkoutData = $this->getCheckoutData();

        $mockCheckouts = Mockery::mock(Checkouts::class);
        $mockCheckouts->shouldReceive('create')
            ->andReturn(CheckoutEntity::from($checkoutData));

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->checkouts = $mockCheckouts;

        $this->app->instance(Creem::class, $mockCreem);

        $creem = app(Creem::class);

        $request = CreateCheckoutRequest::from([
            'product_id' => 'prod_test123',
            'success_url' => 'https://example.com/success',
            'metadata' => ['user_id' => 'user_123'],
        ]);

        $checkout = $creem->checkouts->create($request);

        $this->assertNotNull($checkout);
        $this->assertEquals('checkout_test123', $checkout->id);
        $this->assertNotEmpty($checkout->checkoutUrl);
    }

    public function test_can_retrieve_checkout()
    {
        $checkoutData = $this->getCheckoutData([
            'status' => 'completed',
        ]);

        $mockCheckouts = Mockery::mock(Checkouts::class);
        $mockCheckouts->shouldReceive('retrieve')
            ->with('checkout_test123')
            ->andReturn(CheckoutEntity::from($checkoutData));

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->checkouts = $mockCheckouts;

        $this->app->instance(Creem::class, $mockCreem);

        $creem = app(Creem::class);
        $checkout = $creem->checkouts->retrieve('checkout_test123');

        $this->assertNotNull($checkout);
        $this->assertEquals('checkout_test123', $checkout->id);
        $this->assertEquals('completed', $checkout->status->value);
    }

    public function test_checkout_entity_properties()
    {
        $checkoutData = $this->getCheckoutData([
            'success_url' => 'https://example.com/success',
            'expires_at' => 1705320000,
        ]);

        $checkout = CheckoutEntity::from($checkoutData);

        $this->assertEquals('checkout_test123', $checkout->id);
        $this->assertEquals('https://checkout.creem.io/test123', $checkout->checkoutUrl);
        $this->assertEquals('pending', $checkout->status->value);
        $this->assertEquals('prod', $checkout->mode->value);
    }
}
