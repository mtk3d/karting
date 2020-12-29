<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Availability\Domain\ResourceItem;
use App\Availability\Domain\Slots;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

function aResource(ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId, Slots::of(1));
}

function aWithdrawnResource(ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId, Slots::of(1), false);
}

function aResourceReservedBetween(ResourceId $resourceId = null, string $from, string $to): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(1));
    $resource->reserve(CarbonPeriod::create($from, $to));
    return $resource;
}

function aResourceNoSlotsBetween(ResourceId $resourceId = null, string $from, string $to): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(1));
    $resource->reserve(CarbonPeriod::create($from, $to));
    return $resource;
}

function aResourceWithSlotBetween(ResourceId $resourceId = null, string $from, string $to): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(2));
    $resource->reserve(CarbonPeriod::create($from, $to));
    return $resource;
}
