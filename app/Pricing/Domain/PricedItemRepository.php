<?php

declare(strict_types=1);


namespace Karting\Pricing\Domain;

use Illuminate\Support\Collection;

interface PricedItemRepository
{
    public function save(PricedItem $pricedItem): void;
    public function findIn(Collection $resources): Collection;
}
