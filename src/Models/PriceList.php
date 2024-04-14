<?php
namespace Mothergroup\PriceLists\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mothergroup\AuditLog\Models\HasAuditLogModel;
use Mothergroup\Pods\Models\Pod;
use Mothergroup\PriceLists\Events\PriceListChange;
use Mothergroup\Users\Models\Company;

/**
 * Mothergroup\PriceLists\Models\PriceList
 *
 * @property int $id
 * @property int|null $pod_id
 * @property int|null $company_id
 * @property string $name
 * @property string $country
 * @property bool $is_shared
 * @property array|null $product_categories
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Company|null $company
 * @property-read Pod|null $pod
 * @property-read \Illuminate\Database\Eloquent\Collection|\Mothergroup\PriceLists\Models\PriceListPrice[] $prices
 * @property-read int|null $prices_count
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList newQuery()
 * @method static \Illuminate\Database\Query\Builder|PriceList onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereIsShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList wherePodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereProductCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceList whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|PriceList withTrashed()
 * @method static \Illuminate\Database\Query\Builder|PriceList withoutTrashed()
 * @mixin \Eloquent
 */
class PriceList extends HasAuditLogModel
{
    use SoftDeletes;

    protected $table = 'price_lists';

    protected $casts = [
        "is_shared" => "boolean",

        "product_categories" => "array",
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setAuditLogModel(
            new PriceListAuditLog(),
            [],
            [],
            []);
    }

    public function save(array $options = []): bool
    {
        $result = parent::save($options);

        event(new PriceListChange($this));

        return $result;
    }

    public function delete(): bool
    {
        $result = parent::delete();

        event(new PriceListChange($this));

        return $result;
    }

    /** @return Company|BelongsTo */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /** @return Pod|BelongsTo */
    public function pod(): BelongsTo
    {
        return $this->belongsTo(Pod::class, 'pod_id');
    }

    /** @return PriceListPrice[]|HasMany */
    public function prices(): HasMany
    {
        return $this->hasMany(PriceListPrice::class, "price_list_id");
    }
}
