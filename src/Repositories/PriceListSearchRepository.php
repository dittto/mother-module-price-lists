<?php
namespace Mothergroup\PriceLists\Repositories;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Mothergroup\PriceLists\Clients\PriceListClientInterface;
use Mothergroup\Searching\Client\SearchClientInterface;

class PriceListSearchRepository implements PriceListSearchRepositoryInterface
{
    private Client $client;

    public function __construct(SearchClientInterface $searchClient)
    {
        $this->client = $searchClient->getClient();
    }

    public function findBySearchTerms(array $searchTerms, ?int $companyId, int $page, array $sortOptions, int $pageSize): array
    {
        $sort = [];
        foreach ($sortOptions as $field => $orderBy) {
            $sort[] = [
                $field => ["order" => $orderBy],
            ];
        }

        try {
            $search = [
                'index' => PriceListClientInterface::INDEX_NAME,
                'type' => PriceListClientInterface::TYPE_NAME,
                'size' => $pageSize,
                'from' => $pageSize * ($page - 1),
                'body' => [
                    'sort' => $sort,
                ],
            ];

            foreach ($searchTerms as $term) {
                $shoulds = [
                    ["wildcard" => ["name" => sprintf("*%s*", $term)]],
                ];

                $must = [
                    "bool" => [
                        "should" => $shoulds,
                        'minimum_should_match' => 1,
                    ],
                ];

                $search['body']['query']['bool']['must'][] = $must;
            }

            if ($companyId) {
                $search["body"]["query"]["bool"]["must"][] = [
                    "match" => [
                        'company_id' => $companyId,
                    ],
                ];
            }

            $result = $this->client->search($search);

        } catch (BadRequest400Exception|NoNodesAvailableException $e) {
            dd($e);
            return ['total' => 0, 'items' => []];
        }

        return [
            "total" => $result['hits']['total']["value"] ?? 0,
            "items" => array_filter(array_map(function (array $item) { return $item["_source"] ?? null; }, $result["hits"]["hits"] ?? [])),
        ];
    }

    public function findById(string $id): ?array
    {
        try {
            $result = $this->client->get([
                'index' => PriceListClientInterface::INDEX_NAME,
                'type' => PriceListClientInterface::TYPE_NAME,
                'id' => $id,
            ]);
        } catch (ElasticsearchException $e) {
            $result = null;
        }

        if (!$result) {
            return [];
        }

        return $result['_source'] ?? [];
    }
}
