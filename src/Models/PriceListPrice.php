<?php
namespace Mothergroup\PriceLists\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Mothergroup\PriceLists\Models\PriceListPrice
 *
 * @property int $id
 * @property int $price_list_id
 * @property string $prices
 * @property \Carbon\Carbon $from
 * @property \Carbon\Carbon|null $to
 * @property-read \Mothergroup\PriceLists\Models\PriceList $priceList
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice wherePriceListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice wherePrices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListPrice whereTo($value)
 * @mixin \Eloquent
 */
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
