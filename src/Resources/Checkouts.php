<?php

namespace Creem\Resources;

use Creem\Data\Entities\CheckoutEntity;
use Creem\Data\Requests\CreateCheckoutRequest;

class Checkouts extends Resource
{
    /**
     * Retrieve a checkout by ID.
     */
    public function retrieve(string $checkoutId): CheckoutEntity
    {
        $response = $this->client->get('/v1/checkouts', [
            'checkout_id' => $checkoutId,
        ]);

        return CheckoutEntity::from($response);
    }

    /**
     * Create a new checkout session.
     */
    public function create(CreateCheckoutRequest $request): CheckoutEntity
    {
        $response = $this->client->post('/v1/checkouts', $request->toArray());

        return CheckoutEntity::from($response);
    }
}
