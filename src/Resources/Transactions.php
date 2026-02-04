<?php

namespace Creem\Resources;

use Creem\Data\Entities\TransactionEntity;

class Transactions extends Resource
{
    /**
     * Retrieve a transaction by ID.
     */
    public function getById(string $transactionId): TransactionEntity
    {
        $response = $this->client->get('/v1/transactions', [
            'id' => $transactionId,
        ]);

        return TransactionEntity::from($response);
    }

    /**
     * Search transactions with filters and pagination.
     */
    public function search(
        ?string $customerId = null,
        ?string $orderId = null,
        ?string $productId = null,
        ?int $pageNumber = null,
        ?int $pageSize = null
    ): array {
        $query = array_filter([
            'customer_id' => $customerId,
            'order_id' => $orderId,
            'product_id' => $productId,
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ], fn($v) => $v !== null);

        $response = $this->client->get('/v1/transactions/search', $query);

        return [
            'items' => array_map(
                fn($item) => TransactionEntity::from($item),
                $response['items'] ?? []
            ),
            'pagination' => $response['pagination'] ?? null,
        ];
    }
}
