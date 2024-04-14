<?php
namespace Mothergroup\PriceLists\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Mothergroup\PriceLists\Models\PriceList;

class PriceListRepository implements PriceListRepositoryInterface
{
    public function findAll(): Collection
    {
        return PriceList::all();
    }

    public function findById(int $id): ?PriceList
    {
        $result = PriceList::query()->find($id);

        return $result instanceof PriceList ? $result : null;
    }

    public function findByCompany(int $companyId): Collection
    {
        return PriceList::query()
            ->where("company_id", "=", $companyId)
            ->get();
    }

    public function findByPod(int $podId): Collection
    {
        return PriceList::query()
            ->where("pod_id", "=", $podId)
            ->get();
    }
}
