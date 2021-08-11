<?php

declare(strict_types=1);

namespace Karting\Pricing\Infrastructure\Repository;

use Illuminate\Support\Collection;
use Karting\Pricing\Domain\PricedItem;
use Karting\Pricing\Domain\PricedItemRepository;
use Karting\Shared\Common\UUID;

class InMemoryPricedItemRepository implements PricedItemRepository
{
    private Collection $pricedItems;

    public function __construct()
    {
        $this->pricedItems = new Collection();
    }

    public function save(PricedItem $pricedItem): void
    {
        $this->pricedItems->put((string)$pricedItem->id(), $pricedItem);
    }

    public function findIn(Collection $resources): Collection
    {
        return $this->pricedItems
            ->filter(fn (PricedItem $pricedItem): bool => $resources->contains($pricedItem->id()));
    }

    public function find(UUID $id): PricedItem
    {
        return $this->pricedItems->get((string)$id);
    }
}
