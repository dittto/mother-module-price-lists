<?php
namespace Mothergroup\PriceLists\Listeners;

use Mothergroup\PriceLists\Events\PriceListChange;
use Mothergroup\PriceLists\Helpers\PriceListSearchHelperInterface;

class OnPriceListChangeUpdateSearch
{
    private PriceListSearchHelperInterface $searchHelper;

    public function __construct(PriceListSearchHelperInterface $searchHelper)
    {
        $this->searchHelper = $searchHelper;
    }

    public function handle(PriceListChange $event): void
    {
        $deleted_at = $event->getPriceList()->deleted_at;

        $result = ($deleted_at === null || $deleted_at->year < 1)
            ? $this->searchHelper->update($event->getPriceList())
            : $this->searchHelper->delete($event->getPriceList());
    }
}
