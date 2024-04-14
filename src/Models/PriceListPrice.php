<?php
namespace Mothergroup\PriceLists\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceListPrice extends Model
{
    public $timestamps = false;

    protected $table = 'price_list_prices';

    protected $dates = [
        'from',
        'to',
    ];

    /** @return PriceList|BelongsTo */
    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class, 'price_list_id');
    }
}
