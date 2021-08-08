<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Karting\Availability\Domain\ResourceItem;
use Karting\Availability\Domain\Slots;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;

function aResource(?ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId, Slots::of(1));
}

function aWithdrawnResource(?ResourceId $resourceId = null): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    return ResourceItem::of($resourceId, Slots::of(1), false);
}

function aResourceReservedBetween(?ResourceId $resourceId, string $from, string $to, ReservationId $reservationId): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(1));
    $resource->reserve(CarbonPeriod::create($from, $to), $reservationId);
    return $resource;
}

function aResourceNoSlotsBetween(?ResourceId $resourceId, string $from, string $to, ReservationId $reservationId): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(1));
    $resource->reserve(CarbonPeriod::create($from, $to), $reservationId);
    return $resource;
}

function aResourceWithSlotBetween(?ResourceId $resourceId, string $from, string $to, ReservationId $reservationId): ResourceItem
{
    if (!$resourceId) {
        $resourceId = ResourceId::newOne();
    }

    $resource = ResourceItem::of($resourceId, Slots::of(2));
    $resource->reserve(CarbonPeriod::create($from, $to), $reservationId);
    return $resource;
}
