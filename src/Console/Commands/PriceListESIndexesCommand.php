<?php
namespace Mothergroup\PriceLists\Console\Commands;

use Illuminate\Console\Command;
use Mothergroup\PriceLists\Clients\PriceListClientInterface;

class PriceListESIndexesCommand extends Command
{
    protected $signature = 'price-lists:update-es-indices {--clean : Set this to empty out the indices of all data before updating}';
    protected $description = 'Create Elastic Search index for price lists';

    public function handle(PriceListClientInterface $client): void
    {
        $isClean = $this->option('clean');

        if ($client->pingClient()) {
            $this->info('Client active');
        }

        if ($isClean && $client->hasIndex()) {
            $this->warn('Removing old index');
            $client->deleteIndex();
        }

        if (!$client->hasIndex()) {
            $this->info('Updating index');
            $client->createIndex();
        }
        $this->info('Updating mapping');
        $client->updateMapping();
        $this->info('Complete');
    }
}
