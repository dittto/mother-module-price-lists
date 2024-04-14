<?php
namespace Mothergroup\PriceLists\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mothergroup\AuditLog\Models\HasAuditLogModel;
use Mothergroup\Pods\Models\Pod;
use Mothergroup\PriceLists\Events\PriceListChange;
use Mothergroup\Users\Models\Company;

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
