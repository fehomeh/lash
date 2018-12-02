<?php

namespace App\UseCase\OrderDraft;

use App\Repository\OrderListRepositoryInterface;

class ListAllOrders
{
    /**
     * @var OrderListRepositoryInterface
     */
    private $orderRepository;

    /**
     * ListAllOrders constructor.
     * @param OrderListRepositoryInterface $orderRepository
     */
    public function __construct(OrderListRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Returns list of all orders.
     *
     * @return array
     */
    public function execute(): array
    {
        return $this->orderRepository->findAll();
    }
}
