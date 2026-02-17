<?php

namespace Creem\Webhooks;

use Illuminate\Support\Facades\Log;
use Creem\Webhooks\Events\CreemWebhookReceived;
use Creem\Webhooks\Events\CheckoutCompleted;
use Creem\Webhooks\Events\SubscriptionActive;
use Creem\Webhooks\Events\SubscriptionCanceled;
use Creem\Webhooks\Events\SubscriptionPaused;
use Creem\Webhooks\Events\SubscriptionResumed;
use Creem\Webhooks\Events\SubscriptionRenewed;
use Creem\Webhooks\Events\SubscriptionUpgraded;
use Creem\Webhooks\Events\SubscriptionUnpaid;
use Creem\Webhooks\Events\LicenseActivated;
use Creem\Webhooks\Events\LicenseDeactivated;

class WebhookHandler
{
    protected array $eventMap = [
        'checkout.completed' => CheckoutCompleted::class,
        'subscription.active' => SubscriptionActive::class,
        'subscription.canceled' => SubscriptionCanceled::class,
        'subscription.paused' => SubscriptionPaused::class,
        'subscription.resumed' => SubscriptionResumed::class,
        'subscription.renewed' => SubscriptionRenewed::class,
        'subscription.upgraded' => SubscriptionUpgraded::class,
        'subscription.unpaid' => SubscriptionUnpaid::class,
        'license.activated' => LicenseActivated::class,
        'license.deactivated' => LicenseDeactivated::class,
    ];

    public function handle(array $payload, string $rawContent, string $signature, string $secret): void
    {
        // Verify signature using raw content
        WebhookSignature::verify($rawContent, $signature, $secret);

        // Parse event
        $event = WebhookEvent::from($payload);

        // Dispatch generic event
        event(new CreemWebhookReceived($event));

        // Dispatch specific event
        $this->dispatchSpecificEvent($event);

        if (config('creem.debug')) {
            Log::debug('Creem webhook received', [
                'event_type' => $event->eventType,
                'data' => $event->data,
            ]);
        }
    }

    protected function dispatchSpecificEvent(WebhookEvent $event): void
    {
        $eventClass = $this->eventMap[$event->eventType] ?? null;

        if ($eventClass && class_exists($eventClass)) {
            event(new $eventClass($event));
        }
    }
}
