<?php
namespace Mothergroup\PriceLists\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Mothergroup\PriceLists\Models\PriceList;

interface PriceListRepositoryInterface
{
    /** @return PriceList[]|Collection */
    public function findAll(): Collection;

    public function findById(int $id): ?PriceList;

    /** @return PriceList[]|Collection */
    public function findByCompany(int $companyId): Collection;

    /** @return PriceList[]|Collection */
    public function findByPod(int $podId): Collection;
}
