<?php

namespace Lash\Domain\Product;

use Lash\Domain\Product\Entity\Product;
use Lash\Domain\Product\Exception\DuplicateProductException;
use Lash\Domain\Product\ValueObject\Size;
use Ramsey\Uuid\Uuid;

class ProductFactory
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductFactory constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Creates new Product of unique type, size and color.
     *
     * @param float $price
     * @param string $productType
     * @param string $color
     * @param string $size
     *
     * @return Product
     */
    public function create(float $price, string $productType, string $color, string $size): Product
    {
        $sizeVO = $this->createSize($size);
        if ($this->productRepository->findBy($productType, $color, $sizeVO)) {
            throw new DuplicateProductException(
                sprintf('Product "%s" of color "%s" and size "%s" already exists.', $productType, $color, $size)
            );
        }

        return new Product(Uuid::uuid1(), $price, $productType, $color, $sizeVO);
    }

    /**
     * @param string $size
     * @return Size
     */
    private function createSize(string $size): Size
    {
        return new Size($size);
    }
}
