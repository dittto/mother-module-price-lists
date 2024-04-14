<?php
namespace Mothergroup\PriceLists\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Mothergroup\PriceLists\Helpers\PriceListSearchHelperInterface;
use Mothergroup\PriceLists\Repositories\PriceListRepositoryInterface;

class PriceListMigrateToElasticSearchCommand extends Command
{
    protected $signature = 'price-lists:migrate';
    protected $description = 'Migrate price lists to Elastic Search';

    public function handle(
        PriceListSearchHelperInterface $helper,
        PriceListRepositoryInterface $priceListRepo
    ): void
    {
        $this->info(sprintf('%s - Finding price lists to migrate', Carbon::now()->format('H:i:s')));

        $priceLists = $priceListRepo->findAll();

        foreach ($priceLists as $priceList) {
            $helper->update($priceList, false);
        }

        $this->info(sprintf('%s - Complete', Carbon::now()->format('H:i:s')));
    }
}
