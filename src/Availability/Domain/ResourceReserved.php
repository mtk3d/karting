<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ResourceReserved implements DomainEvent
{
    public function __construct(
        private UUID $id,
        private ResourceId $resourceId,
        private CarbonPeriod $period,
        private ReservationId $reservationId
    ) {
    }

    public static function newOne(ResourceId $resourceId, CarbonPeriod $period, ReservationId $reservationId): ResourceReserved
    {
        return new ResourceReserved(UUID::random(), $resourceId, $period, $reservationId);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function resourceId(): ResourceId
    {
        return $this->resourceId;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }
}
