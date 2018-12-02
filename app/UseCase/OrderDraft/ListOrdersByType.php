<?php

namespace App\UseCase\OrderDraft;

use App\Repository\OrderListRepositoryInterface;
use Lash\Domain\Product\ProductRepositoryInterface;

class ListOrdersByType
{
    /**
     * @var OrderListRepositoryInterface
     */
    private $listOrderRepository;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ListOrdersByType constructor.
     * @param OrderListRepositoryInterface $listOrderRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        OrderListRepositoryInterface $listOrderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->listOrderRepository = $listOrderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Returns list of orders containing given product type
     *
     * @param string $productType
     *
     * @return array
     */
    public function execute(string $productType): array
    {
        $product = $this->productRepository->getByType($productType);

        return $this->listOrderRepository->findByProduct($product);
    }
}
