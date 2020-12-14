<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Availability\Domain\ResourceItem;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

function aResource(ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId);
}

function aWithdrawnResource(ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId, false);
}

function aResourceReservedBetween(ResourceId $resourceId = null, string $from, string $to): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId);
    $resource->reserve(CarbonPeriod::create($from, $to));
    return $resource;
}
