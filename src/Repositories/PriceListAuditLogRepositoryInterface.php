<?php
namespace Mothergroup\PriceLists\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Mothergroup\AuditLog\Repositories\AuditLogRepositoryInterface;
use Mothergroup\PriceLists\Models\PriceListAuditLog;

interface PriceListAuditLogRepositoryInterface extends AuditLogRepositoryInterface
{
    /** @return PriceListAuditLog[]|Collection */
    public function getByObjectId(int $objectId, int $limit = 1000): Collection;
}
