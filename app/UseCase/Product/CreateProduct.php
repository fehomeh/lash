<?php

namespace App\UseCase\Product;

use Lash\Domain\Product\ProductFactory;
use Lash\Domain\Product\ProductRepositoryInterface;
use Lash\Domain\Product\Entity\Product as ProductEntity;

class CreateProduct
{
    /**
     * @var ProductFactory
     */
    private $factory;

    /**
     * @var ProductRepositoryInterface
     */
    private $repository;

    /**
     * CreateProduct constructor.
     * @param ProductFactory $factory
     * @param ProductRepositoryInterface $repository
     */
    public function __construct(ProductFactory $factory, ProductRepositoryInterface $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @param float $price
     * @param string $productType
     * @param string $color
     * @param string $size
     *
     * @return ProductEntity
     */
    public function execute(float $price, string $productType, string $color, string $size): ProductEntity
    {
        $product = $this->factory->create($price, $productType, $color, $size);
        $this->repository->save($product);

        return $product;
    }
}
