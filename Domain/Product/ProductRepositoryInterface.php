<?php

namespace Lash\Domain\Product;

use Lash\Domain\Product\Entity\Product;
use Lash\Domain\Product\Exception\ProductNotFoundException;
use Lash\Domain\Product\ValueObject\Size;
use Ramsey\Uuid\UuidInterface;

interface ProductRepositoryInterface
{
    /**
     * Returns product by given search arguments, returns null if product not found.
     *
     * @param string $productType
     * @param string $color
     * @param Size $size
     *
     * @return Product|null
     */
    public function findBy(string $productType, string $color, Size $size): ?Product;

    /**
     * Stores product to DB.
     *
     * @param Product $product
     */
    public function save(Product $product): void;

    /**
     * @param UuidInterface $uuid
     * @return Product
     *
     * @throws ProductNotFoundException
     */
    public function getById(UuidInterface $uuid): Product;

    /**
     * @param string $productType
     * @return Product
     *
     * @throws ProductNotFoundException
     */
    public function getByType(string $productType): Product;
}
