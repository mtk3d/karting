<?php

declare(strict_types=1);

namespace Karting\Pricing\Infrastructure\Repository;

use Illuminate\Support\Collection;
use Karting\Pricing\Domain\PricedItem;
use Karting\Pricing\Domain\PricedItemRepository;
use Karting\Shared\Common\UUID;

class EloquentPricedItemRepository implements PricedItemRepository
{
    public function save(PricedItem $pricedItem): void
    {
        $pricedItem->save();
    }

    /**
     * @param Collection<int, UUID> $resources
     */
    public function findIn(Collection $resources): Collection
    {
        return PricedItem::whereIn('uuid', $resources)->get();
    }
}
