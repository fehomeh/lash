<?php

namespace Lash\Domain\Order\Entity;

use Lash\Domain\Order\Exception\NotEnoughOrderSumException;
use Lash\Domain\Product\Entity\Product;
use Ramsey\Uuid\UuidInterface;

class OrderDraft
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var \SplObjectStorage
     */
    private $products;

    /**
     * OrderDraft constructor.
     * @param UuidInterface $id
     * @param string $countryCode
     * @param \SplObjectStorage $products
     */
    public function __construct(
        UuidInterface $id,
        string $countryCode,
        \SplObjectStorage $products
    ) {
        $this->id = $id;
        $this->countryCode = $countryCode;
        $this->products = $products;
        $totalPrice = $this->calculateSum();
        if ($totalPrice < 10) {
            throw new NotEnoughOrderSumException('Order sum is less than 10.');
        }
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getProducts(): \SplObjectStorage
    {
        return $this->products;
    }

    /**
     * @return float
     */
    public function calculateSum(): float
    {
        $totalPrice = 0;
        /**
         * @var Product $product
         */
        foreach ($this->products as $product) {
            $quantity = $this->products->getInfo();
            $totalPrice += $product->getPrice() * $quantity;
        }

        return $totalPrice;
    }
}
