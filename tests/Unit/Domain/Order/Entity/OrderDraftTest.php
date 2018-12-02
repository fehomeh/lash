<?php

namespace Tests\Unit\Domain\Order\Entity;

use Lash\Domain\Order\Entity\OrderDraft;
use Lash\Domain\Product\Entity\Product;
use Lash\Domain\Product\ValueObject\Size;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class OrderDraftTest extends TestCase
{
    public function testProperFieldsFilling(): void
    {
        $uuid = Uuid::uuid1();
        $countryCode = 'LV';
        $products = $this->getProducts($uuid, 4);

        $order = $this->createOrder($uuid, $countryCode, $products);

        self::assertSame($uuid, $order->getId());
        self::assertSame($countryCode, $order->getCountryCode());
        self::assertSame(10.0, $order->calculateSum());
        self::assertSame($products, $order->getProducts());
    }

    /**
     * @expectedException \Lash\Domain\Order\Exception\NotEnoughOrderSumException
     */
    public function testSmallSumException(): void
    {
        $uuid = Uuid::uuid1();
        $countryCode = 'US';
        $products = $this->getProducts($uuid, 3);
        $this->createOrder($uuid, $countryCode, $products);
    }

    /**
     * @param UuidInterface $uuid
     * @param int $quantity
     *
     * @return \SplObjectStorage
     */
    private function getProducts(UuidInterface $uuid, int $quantity): \SplObjectStorage
    {
        $products = new \SplObjectStorage();
        $product = new Product($uuid, 2.5, 'unit_product', 'black', new Size(Size::L));
        $products->attach($product, $quantity);

        return $products;
    }

    /**
     * @param UuidInterface $uuid
     * @param string $countryCode
     * @param \SplObjectStorage $products
     *
     * @return OrderDraft
     */
    private function createOrder(UuidInterface $uuid, string $countryCode, \SplObjectStorage $products): OrderDraft
    {
        return new OrderDraft($uuid, $countryCode, $products);
    }
}
