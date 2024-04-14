<?php
namespace Mothergroup\PriceLists\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mothergroup\AuditLog\Models\AuditLogModelInterface;

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
