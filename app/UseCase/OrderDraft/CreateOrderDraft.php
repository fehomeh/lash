<?php

namespace App\UseCase\OrderDraft;

use App\UseCase\OrderDraft\Exception\OrderLimitReachedException;
use Lash\Domain\Order\Event\OrderDraftCreated;
use Lash\Domain\Order\OrderDraftFactory;
use Lash\Domain\Order\OrderDraftRepositoryInterface;
use Lash\Domain\Order\OriginRepositoryInterface;
use Lash\Domain\Order\OriginRequestCounterInterface;
use Lash\Domain\Product\ProductRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CreateOrderDraft
{
    /**
     * @var OriginRepositoryInterface
     */
    private $originRepository;

    /**
     * @var OrderDraftRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var OrderDraftFactory
     */
    private $orderFactory;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var OriginRequestCounterInterface
     */
    private $requestCounter;

    /**
     * @var int How many requests are allowed from one country in a specific time range.
     */
    private $maxRequests = 1;

    /**
     * CreateOrderDraft constructor.
     * @param OriginRepositoryInterface $originRepository
     * @param OrderDraftRepositoryInterface $orderRepository
     * @param OrderDraftFactory $orderFactory
     * @param ProductRepositoryInterface $productRepository
     * @param OriginRequestCounterInterface $requestCounter
     */
    public function __construct(
        OriginRepositoryInterface $originRepository,
        OrderDraftRepositoryInterface $orderRepository,
        OrderDraftFactory $orderFactory,
        ProductRepositoryInterface $productRepository,
        OriginRequestCounterInterface $requestCounter
    ) {
        $this->originRepository = $originRepository;
        $this->orderRepository = $orderRepository;
        $this->orderFactory = $orderFactory;
        $this->productRepository = $productRepository;
        $this->requestCounter = $requestCounter;
    }

    /**
     * Creates draft of an order and returns payment sum.
     *
     * @param array $productIdToQuantity
     * @param string $ipAddress
     *
     * @return float
     */
    public function execute(array $productIdToQuantity, string $ipAddress): float
    {
        $country = $this->originRepository->getCountryCode($ipAddress);
        if ($this->isLimitForOriginReached($country)) {
            throw new OrderLimitReachedException(
                'Limit of requests is reached. Please, try again later.'
            );
        }
        $products = new \SplObjectStorage();
        foreach ($productIdToQuantity as $productId => $quantity) {
            if (0 === $quantity) {
                continue;
            }
            $product = $this->productRepository->getById(Uuid::fromString($productId));
            $products->attach($product, $quantity);
        }
        $order = $this->orderFactory->create($country, $products);
        $this->orderRepository->save($order);
        event(new OrderDraftCreated($order));

        return $order->calculateSum();
    }

    /**
     * @param int $maxRequests
     */
    public function setMaxRequests(int $maxRequests): void
    {
        $this->maxRequests = $maxRequests;
    }

    /**
     * @param string $country
     *
     * @return bool
     */
    private function isLimitForOriginReached(string $country): bool
    {
        return $this->requestCounter->countRequest($country) > $this->getMaxRequestNumber();
    }

    /**
     * @return int
     */
    private function getMaxRequestNumber(): int
    {
        return $this->maxRequests;
    }
}
