<?php

namespace Tests\Feature\OrderDraft;

use App\Repository\OrderListRepositoryInterface;
use Tests\TestCase;

class ListAllOrdersControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $mockRepository = $this->getMockBuilder(OrderListRepositoryInterface::class)->getMock();
        $mockRepository->method('findAll')->willReturn([]);

        $this->app->singleton(OrderListRepositoryInterface::class, function () use ($mockRepository) {
            return $mockRepository;
        });
    }

    /**
     * Smoke test for API GET /api/orders
     *
     * @return void
     */
    public function testOkResponse(): void
    {
        $response = $this->get('/api/orders');

        $response->assertStatus(200);
    }
}
