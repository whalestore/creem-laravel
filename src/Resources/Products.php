<?php

namespace Creem\Resources;

use Creem\Data\Entities\ProductEntity;
use Creem\Data\Requests\CreateProductRequest;

class Products extends Resource
{
    /**
     * Retrieve a product by ID.
     */
    public function get(string $productId): ProductEntity
    {
        $response = $this->client->get('/v1/products', [
            'product_id' => $productId,
        ]);

        return ProductEntity::from($response);
    }

    /**
     * Create a new product.
     */
    public function create(CreateProductRequest $request): ProductEntity
    {
        $response = $this->client->post('/v1/products', $request->toArray());

        return ProductEntity::from($response);
    }

    /**
     * Search products with pagination.
     */
    public function search(?int $pageNumber = null, ?int $pageSize = null): array
    {
        $query = array_filter([
            'page_number' => $pageNumber,
            'page_size' => $pageSize,
        ], fn($v) => $v !== null);

        $response = $this->client->get('/v1/products/search', $query);

        return [
            'items' => array_map(
                fn($item) => ProductEntity::from($item),
                $response['items'] ?? []
            ),
            'pagination' => $response['pagination'] ?? null,
        ];
    }
}
