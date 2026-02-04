<?php

namespace Creem\Resources;

use Creem\Data\Entities\CustomerEntity;
use Creem\Data\Requests\CreateCustomerPortalLinkRequest;

class Customers extends Resource
{
    /**
     * List customers with pagination.
     */
    public function list(?int $pageNumber = null, ?int $pageSize = null): array
    {
        $query = array_filter([
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ], fn($v) => $v !== null);

        $response = $this->client->get('/v1/customers', $query);

        return [
            'items' => array_map(
                fn($item) => CustomerEntity::from($item),
                $response['items'] ?? []
            ),
            'pagination' => $response['pagination'] ?? null,
        ];
    }

    /**
     * Retrieve a customer by ID or email.
     */
    public function retrieve(?string $customerId = null, ?string $email = null): CustomerEntity
    {
        $query = array_filter([
            'customer_id' => $customerId,
            'email' => $email,
        ], fn($v) => $v !== null);

        $response = $this->client->get('/v1/customers/retrieve', $query);

        return CustomerEntity::from($response);
    }

    /**
     * Generate billing portal links for a customer.
     */
    public function generateBillingLinks(CreateCustomerPortalLinkRequest $request): array
    {
        $response = $this->client->post('/v1/customers/billing-portal', $request->toArray());

        return $response;
    }
}
