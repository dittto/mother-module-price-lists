<?php
namespace Mothergroup\PriceLists\Repositories;

interface PriceListSearchRepositoryInterface
{
    public function findBySearchTerms(array $searchTerms, ?int $companyId, int $page, array $sortOptions, int $pageSize): array;

    public function findById(string $id): ?array;
}
