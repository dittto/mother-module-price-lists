<?php
namespace Mothergroup\PriceLists\Helpers;

use Mothergroup\PriceLists\Models\PriceList;

interface PriceListSearchHelperInterface
{
    public function update(PriceList $priceList, bool $waitForRefresh = true): bool;

    public function delete(PriceList $priceList, bool $waitForRefresh = true): bool;
}
