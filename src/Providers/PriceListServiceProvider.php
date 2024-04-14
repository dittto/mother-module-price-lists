<?php
namespace Mothergroup\PriceLists\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Mothergroup\PriceLists\Clients\PriceListClient;
use Mothergroup\PriceLists\Clients\PriceListClientInterface;
use Mothergroup\PriceLists\Helpers\PriceListSearchHelper;
use Mothergroup\PriceLists\Helpers\PriceListSearchHelperInterface;
use Mothergroup\PriceLists\Repositories\PriceListAuditLogRepository;
use Mothergroup\PriceLists\Repositories\PriceListAuditLogRepositoryInterface;
use Mothergroup\PriceLists\Repositories\PriceListRepository;
use Mothergroup\PriceLists\Repositories\PriceListRepositoryInterface;
use Mothergroup\PriceLists\Repositories\PriceListSearchRepository;
use Mothergroup\PriceLists\Repositories\PriceListSearchRepositoryInterface;
use Mothergroup\Searching\Client\SearchClientInterface;

class PriceListServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function provides()
    {
        return [
            PriceListClientInterface::class,
            PriceListSearchHelperInterface::class,
            PriceListSearchRepositoryInterface::class,
            PriceListRepositoryInterface::class,
            PriceListAuditLogRepositoryInterface::class,
        ];
    }

    public function register()
    {
        $this->app->singleton(PriceListClientInterface::class, function (Application $app) {
            return new PriceListClient(
                $app->make(SearchClientInterface::class)
            );
        });

        $this->app->singleton(PriceListSearchHelperInterface::class, function (Application $app) {
            return new PriceListSearchHelper(
                $app->make(PriceListClientInterface::class),
                $app->make(PriceListSearchRepositoryInterface::class)
            );
        });

        $this->app->singleton(PriceListSearchRepositoryInterface::class, function (Application $app) {
            return new PriceListSearchRepository(
                $app->make(SearchClientInterface::class)
            );
        });

        $this->app->singleton(PriceListRepositoryInterface::class, function (Application $app) {
            return new PriceListRepository();
        });

        $this->app->singleton(PriceListAuditLogRepositoryInterface::class, function (Application $app) {
            return new PriceListAuditLogRepository();
        });
    }
}
