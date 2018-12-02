<?php

namespace Tests\Feature\OrderDraft;

use App\Repository\OrderListRepositoryInterface;
use Lash\Domain\Product\Entity\Product;
use Lash\Domain\Product\ProductRepositoryInterface;
use Lash\Domain\Product\ValueObject\Size;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ListOrdersByProductTypeControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $mockOrderRepository = $this->getMockBuilder(OrderListRepositoryInterface::class)->getMock();
        $mockOrderRepository->method('findByProduct')->willReturn([]);
        $mockProductRepository = $this->getMockBuilder(ProductRepositoryInterface::class)->getMock();
        $mockProductRepository->method('getByType')->willReturn(new Product(Uuid::uuid1(), 2.23, 'test_type', 'blue', new Size(Size::XXXXL)));

        $this->app->singleton(OrderListRepositoryInterface::class, function () use ($mockOrderRepository) {
            return $mockOrderRepository;
        });

        $this->app->singleton(ProductRepositoryInterface::class, function () use ($mockProductRepository) {
            return $mockProductRepository;
        });
    }

    public function testOkResponse(): void
    {
        $response = $this->get('/api/orders/test');

        $response->assertStatus(200);
    }
}
