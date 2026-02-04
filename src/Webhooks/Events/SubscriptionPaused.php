<?php

namespace Creem\Webhooks\Events;

use Creem\Webhooks\WebhookEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPaused
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WebhookEvent $event
    ) {}
}
