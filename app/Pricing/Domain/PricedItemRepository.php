<?php

declare(strict_types=1);


namespace Karting\Pricing\Domain;

use Illuminate\Support\Collection;
use Karting\Shared\ResourceId;

interface PricedItemRepository
{
    public function save(PricedItem $pricedItem): void;
    /**
     * @param Collection<int, ResourceId> $resources
     */
    public function findIn(Collection $resources): Collection;
}
