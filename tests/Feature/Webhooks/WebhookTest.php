<?php

namespace Creem\Tests\Feature\Webhooks;

use Creem\Tests\TestCase;
use Creem\Webhooks\WebhookEvent;
use Illuminate\Support\Facades\Event;

class WebhookTest extends TestCase
{
    protected function defineEnvironment($app): void
    {
        parent::defineEnvironment($app);
        $app['config']->set('creem.webhook.secret', 'test_webhook_secret');
    }

    protected function generateSignature(string $payload): string
    {
        return hash_hmac('sha256', $payload, 'test_webhook_secret');
    }

    public function test_webhook_validates_signature()
    {
        $payload = json_encode([
            'event_type' => 'checkout.completed',
            'object' => 'event',
            'data' => [
                'id' => 'checkout_123',
                'status' => 'complete',
            ],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
            'Content-Type' => 'application/json',
        ]);

        $response->assertSuccessful();
    }

    public function test_webhook_rejects_invalid_signature()
    {
        $payload = json_encode([
            'event_type' => 'checkout.completed',
            'object' => 'event',
            'data' => ['id' => 'checkout_123'],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => 'invalid_signature',
            'Content-Type' => 'application/json',
        ]);

        $response->assertStatus(400);
    }

    public function test_webhook_dispatches_event()
    {
        Event::fake();

        $payload = json_encode([
            'event_type' => 'checkout.completed',
            'object' => 'event',
            'data' => [
                'id' => 'checkout_123',
                'status' => 'complete',
                'customer' => ['email' => 'test@example.com'],
            ],
        ]);

        $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        Event::assertDispatched(\Creem\Webhooks\Events\CheckoutCompleted::class);
    }

    public function test_webhook_handles_subscription_active()
    {
        Event::fake();

        $payload = json_encode([
            'event_type' => 'subscription.active',
            'object' => 'event',
            'data' => [
                'id' => 'sub_123',
                'status' => 'active',
                'customer_id' => 'cust_123',
            ],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        $response->assertSuccessful();
        Event::assertDispatched(\Creem\Webhooks\Events\SubscriptionActive::class);
    }

    public function test_webhook_handles_subscription_canceled()
    {
        Event::fake();

        $payload = json_encode([
            'event_type' => 'subscription.canceled',
            'object' => 'event',
            'data' => [
                'id' => 'sub_123',
                'status' => 'canceled',
                'canceled_at' => '2024-01-15T12:00:00Z',
            ],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        $response->assertSuccessful();
        Event::assertDispatched(\Creem\Webhooks\Events\SubscriptionCanceled::class);
    }

    public function test_webhook_handles_subscription_renewed()
    {
        Event::fake();

        $payload = json_encode([
            'event_type' => 'subscription.renewed',
            'object' => 'event',
            'data' => [
                'id' => 'sub_123',
                'status' => 'active',
                'current_period_end' => '2024-03-01T00:00:00Z',
            ],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        $response->assertSuccessful();
        Event::assertDispatched(\Creem\Webhooks\Events\SubscriptionRenewed::class);
    }

    public function test_webhook_handles_license_activated()
    {
        Event::fake();

        $payload = json_encode([
            'event_type' => 'license.activated',
            'object' => 'event',
            'data' => [
                'id' => 'lic_123',
                'key' => 'XXXX-XXXX-XXXX-XXXX',
                'status' => 'active',
            ],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        $response->assertSuccessful();
        Event::assertDispatched(\Creem\Webhooks\Events\LicenseActivated::class);
    }

    public function test_webhook_returns_success_for_unknown_events()
    {
        $payload = json_encode([
            'event_type' => 'unknown.event',
            'object' => 'event',
            'data' => ['id' => 'test'],
        ]);

        $response = $this->postJson(route('creem.webhook'), json_decode($payload, true), [
            'X-Creem-Signature' => $this->generateSignature($payload),
        ]);

        // Should still return success to acknowledge receipt
        $response->assertSuccessful();
    }
}
