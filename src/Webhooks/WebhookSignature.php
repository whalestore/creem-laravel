<?php

namespace Creem\Webhooks;

use Creem\Exceptions\ValidationException;

class WebhookSignature
{
    /**
     * Verify the webhook signature.
     *
     * @throws ValidationException
     */
    public static function verify(string $payload, string $signature, string $secret): bool
    {
        if (empty($secret)) {
            throw new ValidationException('Webhook secret is not configured');
        }

        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            throw new ValidationException('Invalid webhook signature');
        }

        return true;
    }
}
