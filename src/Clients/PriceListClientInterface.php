<?php
namespace Mothergroup\PriceLists\Clients;

interface PriceListClientInterface
{
    public const INDEX_NAME = 'price_lists';
    public const TYPE_NAME = 'type_price_lists';

    public function pingClient(): bool;

    public function hasIndex(): bool;

    public function createIndex(): self;

    public function deleteIndex(): self;

    public function updateMapping(): self;

    public function getMapping(): array;

    public function add(string $id, array $data, bool $waitForRefresh = false): bool;

    public function update(string $id, array $data, bool $waitForRefresh = false): bool;

    public function delete(string $id, bool $waitForRefresh = false): bool;
}
