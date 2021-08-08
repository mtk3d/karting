<?php

declare(strict_types=1);

namespace Karting\Availability\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ResourceReserved implements DomainEvent
{
    private UUID $id;
    private ResourceId $resourceId;
    private CarbonPeriod $period;
    private UUID $reservationId;

    public function __construct(UUID $id, ResourceId $resourceId, CarbonPeriod $period, UUID $reservationId)
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
        $this->period = $period;
        $this->reservationId = $reservationId;
    }

    public static function newOne(ResourceId $resourceId, CarbonPeriod $period, UUID $reservationId): ResourceReserved
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

    public function reservationId(): UUID
    {
        return $this->reservationId;
    }
}
