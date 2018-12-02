<?php

namespace App\Providers;

use App\Repository\OrderListRepositoryInterface;
use App\UseCase\OrderDraft\CreateOrderDraft;
use App\UseCase\Product\CreateProduct;
use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Lash\Domain\Order\OrderDraftFactory;
use Lash\Domain\Order\OrderDraftRepositoryInterface;
use Lash\Domain\Order\OriginRepositoryInterface;
use Lash\Domain\Order\OriginRequestCounterInterface;
use Lash\Domain\Product\ProductFactory;
use Lash\Domain\Product\ProductRepositoryInterface;
use Lash\Infrastructure\Persistence\File\OriginRequestCounter;
use Lash\Infrastructure\Persistence\MySQL\OrderDraft\MySQLOrderDraftRepository;
use Lash\Infrastructure\Persistence\MySQL\OrderDraft\OrderListRepository;
use Lash\Infrastructure\Persistence\MySQL\Product\MySQLProductRepository;
use Lash\Infrastructure\Service\OriginResolving\SxGeoOriginRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->get(CreateOrderDraft::class)->setMaxRequests(env('MAX_ORDERS_FROM_ONE_ORIGIN'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            function (Container $container) {
                return new MySQLProductRepository($container->get('db'));
            }
        );
        $this->app->bind(
            OrderDraftRepositoryInterface::class,
            function (Container $container) {
                return new MySQLOrderDraftRepository($container->get('db'));
            }
        );
        $this->app->bind(
            OriginRepositoryInterface::class,
            function () {
                return new SxGeoOriginRepository(new Client(), env('SYPEX_API_URL'));
            }
        );
        $this->app->bind(
            OriginRequestCounterInterface::class,
            function (Container $container) {
                return new OriginRequestCounter(
                    $container['cache.store'],
                    env('COUNTRY_ORDER_LIMIT_INTERVAL')
                );
            }
        );
        $this->app->bind(
            OrderListRepositoryInterface::class,
            function (Container $container) {
                return new OrderListRepository(
                    $container->get('db')
                );
            }
        );

        $this->app->singleton(CreateProduct::class);
        $this->app->singleton(CreateOrderDraft::class);
        $this->app->singleton(ProductFactory::class);
        $this->app->singleton(OrderDraftFactory::class);
    }
}
