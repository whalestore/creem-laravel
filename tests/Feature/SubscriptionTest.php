<?php

namespace Creem\Tests\Feature;

use Creem\Creem;
use Creem\Data\Entities\SubscriptionEntity;
use Creem\Data\Requests\CancelSubscriptionRequest;
use Creem\Resources\Subscriptions;
use Creem\Tests\TestCase;
use Mockery;

class SubscriptionTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    protected function getSubscriptionData(array $overrides = []): array
    {
        return array_merge([
            'id' => 'sub_test123',
            'mode' => 'prod',
            'object' => 'subscription',
            'status' => 'active',
            'product_id' => 'prod_premium',
            'customer_id' => 'cust_123',
            'current_period_start' => 1704067200,
            'current_period_end' => 1706745600,
        ], $overrides);
    }

    public function test_can_get_subscription()
    {
        $subscriptionData = $this->getSubscriptionData();

        $mockSubscriptions = Mockery::mock(Subscriptions::class);
        $mockSubscriptions->shouldReceive('get')
            ->with('sub_test123')
            ->andReturn(SubscriptionEntity::from($subscriptionData));

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->subscriptions = $mockSubscriptions;

        $this->app->instance(Creem::class, $mockCreem);

        $creem = app(Creem::class);
        $subscription = $creem->subscriptions->get('sub_test123');

        $this->assertNotNull($subscription);
        $this->assertEquals('sub_test123', $subscription->id);
        $this->assertEquals('active', $subscription->status->value);
    }

    public function test_can_cancel_subscription()
    {
        $subscriptionData = $this->getSubscriptionData([
            'status' => 'canceled',
            'canceled_at' => 1705320000,
        ]);

        $mockSubscriptions = Mockery::mock(Subscriptions::class);
        $mockSubscriptions->shouldReceive('cancel')
            ->andReturn(SubscriptionEntity::from($subscriptionData));

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->subscriptions = $mockSubscriptions;

        $this->app->instance(Creem::class, $mockCreem);

        $creem = app(Creem::class);
        $request = CancelSubscriptionRequest::from([]);
        $subscription = $creem->subscriptions->cancel('sub_test123', $request);

        $this->assertNotNull($subscription);
        $this->assertEquals('canceled', $subscription->status->value);
    }

    public function test_subscription_has_active_status()
    {
        $subscriptionData = $this->getSubscriptionData();

        $mockSubscriptions = Mockery::mock(Subscriptions::class);
        $mockSubscriptions->shouldReceive('get')
            ->with('sub_test123')
            ->andReturn(SubscriptionEntity::from($subscriptionData));

        $mockCreem = Mockery::mock(Creem::class);
        $mockCreem->subscriptions = $mockSubscriptions;

        $this->app->instance(Creem::class, $mockCreem);

        $creem = app(Creem::class);
        $subscription = $creem->subscriptions->get('sub_test123');

        $this->assertEquals('active', $subscription->status->value);
        $this->assertNotNull($subscription->currentPeriodEnd);
    }

    public function test_subscription_entity_properties()
    {
        $subscriptionData = $this->getSubscriptionData([
            'status' => 'trialing',
            'trial_end' => 1705190400,
        ]);

        $subscription = SubscriptionEntity::from($subscriptionData);

        $this->assertEquals('sub_test123', $subscription->id);
        $this->assertEquals('trialing', $subscription->status->value);
        $this->assertEquals('prod', $subscription->mode->value);
    }
}
