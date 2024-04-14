<?php
namespace Mothergroup\PriceLists\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Mothergroup\PriceLists\Events\PriceListChange;
use Mothergroup\PriceLists\Listeners\OnPriceListChangeUpdateSearch;
use Mothergroup\PriceLists\Console\Commands\GetPriceListFromESCommand;
use Mothergroup\PriceLists\Console\Commands\PriceListESIndexesCommand;
use Mothergroup\PriceLists\Console\Commands\PriceListMigrateToElasticSearchCommand;

class PriceListReferencesServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GetPriceListFromESCommand::class,
                PriceListESIndexesCommand::class,
                PriceListMigrateToElasticSearchCommand::class,
            ]);
        }

        Event::listen(PriceListChange::class, OnPriceListChangeUpdateSearch::class);
    }
}
