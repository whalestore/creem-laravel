<?php

namespace Creem\Resources;

use Creem\Data\Entities\SubscriptionEntity;
use Creem\Data\Requests\CancelSubscriptionRequest;
use Creem\Data\Requests\UpdateSubscriptionRequest;
use Creem\Data\Requests\UpgradeSubscriptionRequest;

class Subscriptions extends Resource
{
    /**
     * Retrieve a subscription by ID.
     */
    public function get(string $subscriptionId): SubscriptionEntity
    {
        $response = $this->client->get('/v1/subscriptions', [
            'subscription_id' => $subscriptionId,
        ]);

        return SubscriptionEntity::from($response);
    }

    /**
     * Cancel a subscription.
     */
    public function cancel(string $id, CancelSubscriptionRequest $request): SubscriptionEntity
    {
        $data = array_merge(['id' => $id], $request->toArray());
        $response = $this->client->post('/v1/subscriptions/cancel', $data);

        return SubscriptionEntity::from($response);
    }

    /**
     * Update a subscription.
     */
    public function update(string $id, UpdateSubscriptionRequest $request): SubscriptionEntity
    {
        $data = array_merge(['id' => $id], $request->toArray());
        $response = $this->client->post('/v1/subscriptions/update', $data);

        return SubscriptionEntity::from($response);
    }

    /**
     * Upgrade a subscription to a new product.
     */
    public function upgrade(string $id, UpgradeSubscriptionRequest $request): SubscriptionEntity
    {
        $data = array_merge(['id' => $id], $request->toArray());
        $response = $this->client->post('/v1/subscriptions/upgrade', $data);

        return SubscriptionEntity::from($response);
    }

    /**
     * Pause a subscription.
     */
    public function pause(string $id): SubscriptionEntity
    {
        $response = $this->client->post('/v1/subscriptions/pause', ['id' => $id]);

        return SubscriptionEntity::from($response);
    }

    /**
     * Resume a paused subscription.
     */
    public function resume(string $id): SubscriptionEntity
    {
        $response = $this->client->post('/v1/subscriptions/resume', ['id' => $id]);

        return SubscriptionEntity::from($response);
    }
}
