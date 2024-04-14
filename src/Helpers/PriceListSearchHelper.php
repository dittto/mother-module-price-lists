<?php
namespace Mothergroup\PriceLists\Helpers;

use Mothergroup\PriceLists\Clients\PriceListClientInterface;
use Mothergroup\PriceLists\Models\PriceList;
use Mothergroup\PriceLists\Repositories\PriceListSearchRepositoryInterface;

class PriceListSearchHelper implements PriceListSearchHelperInterface
{
    private PriceListClientInterface $client;
    private PriceListSearchRepositoryInterface $searchRepo;

    public function __construct(PriceListClientInterface $client, PriceListSearchRepositoryInterface $searchRepo)
    {
        $this->client = $client;
        $this->searchRepo = $searchRepo;
    }

    public function update(PriceList $priceList, bool $waitForRefresh = true): bool
    {
        $data = [
            'id' => $priceList->id,
            "pod_id" => $priceList->pod_id,
            "company_id" => $priceList->company_id,
            'name' => $priceList->name,
            'sort_name' => strtolower($priceList->full_name),
            "country" => $priceList->country,
            "is_shared" => $priceList->is_shared,
            "catalogues" => null,
            "products" => null,
            "from" => null,
            "to" => null,
        ];

        $results = $this->searchRepo->findById((string) $priceList->id);

        $isValid = ($results !== null && count($results))
            ? $this->client->update($priceList->id, $data, $waitForRefresh)
            : $this->client->add($priceList->id, $data, $waitForRefresh);

        return !!$isValid;
    }

    public function delete(PriceList $priceList, bool $waitForRefresh = true): bool
    {
        return $this->client->delete($priceList->id, $waitForRefresh);
    }
}
