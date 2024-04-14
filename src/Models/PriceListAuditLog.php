<?php
namespace Mothergroup\PriceLists\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mothergroup\AuditLog\Models\AuditLogModelInterface;

/**
 * Mothergroup\PriceLists\Models\PriceListAuditLog
 *
 * @property int $id
 * @property int $object_id
 * @property int $user_id
 * @property array $previous
 * @property array $current
 * @property Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog whereCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog wherePrevious($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PriceListAuditLog whereUserId($value)
 * @mixin \Eloquent
 */
class PriceListAuditLog extends Model implements AuditLogModelInterface
{
    protected $table = 'price_list_audit_logs';

    protected $attributes = [
        'user_id' => 0,
        'object_id' => 0,
    ];

    protected $casts = [
        'previous' => 'array',
        'current' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    public function create(int $id, int $userId, array $previous, array $current): void
    {
        $this->object_id = $id;
        $this->user_id = $userId;
        $this->previous = $previous;
        $this->current = $current;
        $this->created_at = Carbon::now();
        $this->save();
    }
}
