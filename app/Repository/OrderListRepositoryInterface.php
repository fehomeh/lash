<?php

namespace App\Repository;

use Lash\Domain\Product\Entity\Product;

interface OrderListRepositoryInterface
{
    /**
     * Find all orders.
     *
     * @return array
     */
    public function findAll(): array;

    /**
     * Find all orders containing given product.
     *
     * @param Product $product
     *
     * @return array
     */
    public function findByProduct(Product $product): array;
}
