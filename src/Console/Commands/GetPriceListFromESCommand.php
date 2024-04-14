<?php
namespace Mothergroup\PriceLists\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Mothergroup\PriceLists\Repositories\PriceListSearchRepositoryInterface;

class GetPriceListFromESCommand extends Command
{
    protected $signature = 'price-lists:get-from-es {id? : An id for a price list, or blank for all}';
    protected $description = 'Tests getting a price list\'s data from the elasticsearch';

    public function handle(PriceListSearchRepositoryInterface $searchRepo): void
    {
        $id = $this->argument("id") ?? null;
        if ($id) {
            $this->info(sprintf('%s - Finding price list by id #%d', Carbon::now()->format('H:i:s'), $id));
            dd($searchRepo->findById($id));
        }

        $max = 50;
        $this->info(sprintf('%s - Finding all price lists, limited to %d entries', Carbon::now()->format('H:i:s'), $max));

        dd($searchRepo->findBySearchTerms([], null, "", [], [], [], 1, ["id" => "asc"], $max));
    }
}
