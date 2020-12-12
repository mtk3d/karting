<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Availability\Domain\ResourceItem;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

function aResource(): ResourceItem
{
    return ResourceItem::of(ResourceId::newOne());
}

function aWithdrawnResource(): ResourceItem
{
    return ResourceItem::of(ResourceId::newOne(), false);
}

function aResourceReservedBetween(string $from, string $to): ResourceItem
{
    $resource = ResourceItem::of(ResourceId::newOne());
    $resource->reserve(CarbonPeriod::create($from, $to));
    return $resource;
}
