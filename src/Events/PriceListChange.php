<?php
namespace Mothergroup\PriceLists\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Mothergroup\PriceLists\Models\PriceList;

class PriceListChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private PriceList $priceList;

    public function __construct(PriceList $priceList)
    {
        $this->priceList = $priceList;
    }

    public function getPriceList(): PriceList
    {
        return $this->priceList;
    }
}
