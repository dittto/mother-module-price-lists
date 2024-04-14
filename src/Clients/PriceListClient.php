<?php
namespace Mothergroup\PriceLists\Clients;

use Elasticsearch\Client;
use Mothergroup\Searching\Client\SearchClientInterface;

class PriceListClient implements PriceListClientInterface
{
    private Client $client;

    public function __construct(SearchClientInterface $searchClient)
    {
        $this->client = $searchClient->getClient();
    }

    public function pingClient(): bool
    {
        if (!$this->client) {
            return false;
        }

        return $this->client->ping();
    }

    public function hasIndex(): bool
    {
        return $this->client->indices()->exists([
            'index' => PriceListClientInterface::INDEX_NAME,
        ]);
    }

    public function createIndex(): PriceListClientInterface
    {
        $this->client->indices()->create([
            'index' => PriceListClientInterface::INDEX_NAME,
        ]);

        return $this;
    }

    public function deleteIndex(): PriceListClientInterface
    {
        $this->client->indices()->delete([
            'index' => PriceListClientInterface::INDEX_NAME,
        ]);

        return $this;
    }

    public function updateMapping(): PriceListClientInterface
    {
        $mapping = [
            'id' => ['type' => 'keyword'],
            'pod_id' => ['type' => 'keyword'],
            'company_id' => ['type' => 'keyword'],
            'name' => ['type' => 'text'],
            'sort_name' => ['type' => 'text'],
            'country' => ['type' => 'keyword'],
            'is_shared' => ['type' => 'boolean'],
            'catalogues' => ['type' => 'keyword'],
            "products" => ["type" => "keyword"],
            'from' => ['type' => 'date'],
            "to" => ["type" => "date"],
        ];

        $this->client->indices()->putMapping([
            'index' => PriceListClientInterface::INDEX_NAME,
            'type' => PriceListClientInterface::TYPE_NAME,
            'body' => [
                PriceListClientInterface::TYPE_NAME => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => $mapping,
                ],
            ],
            'include_type_name' => true,
        ]);

        return $this;
    }

    public function getMapping(): array
    {
        return $this->client->indices()->getMapping([
            'index' => PriceListClientInterface::INDEX_NAME,
        ]);
    }

    public function add(string $id, array $data, bool $waitForRefresh = false): bool
    {
        if (!$this->client) {
            return false;
        }

        $response = $this->client->index([
            'index' => PriceListClientInterface::INDEX_NAME,
            'type' => PriceListClientInterface::TYPE_NAME,
            'id' => $id,
            'body' => $data
        ] + ($waitForRefresh ? ['refresh' => 'wait_for'] : []));

        return ($response['_id'] ?? null) === $id;
    }

    public function update(string $id, array $data, bool $waitForRefresh = false): bool
    {
        if (!$this->client) {
            return false;
        }

        $response = $this->client->update([
            'index' => PriceListClientInterface::INDEX_NAME,
            'type' => PriceListClientInterface::TYPE_NAME,
            'id' => $id,
            'body' => ['doc' => $data]
        ] + ($waitForRefresh ? ['refresh' => 'wait_for'] : []));

        return ($response['_id'] ?? null) === $id;
    }

    public function delete(string $id, bool $waitForRefresh = false): bool
    {
        if (!$this->client) {
            return false;
        }

        $response = $this->client->delete([
            'index' => PriceListClientInterface::INDEX_NAME,
            'type' => PriceListClientInterface::TYPE_NAME,
            'id' => $id,
        ] + ($waitForRefresh ? ['refresh' => 'wait_for'] : []));

        return ($response['_id'] ?? null) === $id;
    }
}
