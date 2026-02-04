<?php

namespace Creem\Resources;

use Creem\Data\Entities\DiscountEntity;
use Creem\Data\Requests\CreateDiscountRequest;

class Discounts extends Resource
{
    /**
     * Retrieve a discount by ID or code.
     */
    public function get(?string $discountId = null, ?string $discountCode = null): DiscountEntity
    {
        $query = array_filter([
            'discount_id' => $discountId,
            'discount_code' => $discountCode,
        ], fn($v) => $v !== null);

        $response = $this->client->get('/v1/discounts', $query);

        return DiscountEntity::from($response);
    }

    /**
     * Create a new discount.
     */
    public function create(CreateDiscountRequest $request): DiscountEntity
    {
        $response = $this->client->post('/v1/discounts', $request->toArray());

        return DiscountEntity::from($response);
    }

    /**
     * Delete a discount.
     */
    public function delete(string $id): DiscountEntity
    {
        $response = $this->client->delete('/v1/discounts', ['id' => $id]);

        return DiscountEntity::from($response);
    }
}
