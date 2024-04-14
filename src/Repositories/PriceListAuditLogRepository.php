<?php
namespace Mothergroup\PriceLists\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Mothergroup\PriceLists\Models\PriceListAuditLog;

class PriceListAuditLogRepository implements PriceListAuditLogRepositoryInterface
{
    public function getByObjectId(int $objectId, int $limit = 1000): Collection
    {
        $query = PriceListAuditLog::query()
            ->where('object_id', $objectId)
            ->limit($limit)
            ->orderBy('id', 'desc');

        return $query->get();
    }
}
