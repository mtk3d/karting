<?php

declare(strict_types=1);

namespace App\Availability\Domain;

use App\Shared\Common\DomainEvent;
use App\Shared\Common\UUID;
use App\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ResourceReserved implements DomainEvent
{
    private UUID $id;
    private ResourceId $resourceId;
    private CarbonPeriod $period;

    public function __construct(UUID $id, ResourceId $resourceId, CarbonPeriod $period)
    {
        $this->id = $id;
        $this->resourceId = $resourceId;
        $this->period = $period;
    }

    public static function newOne(ResourceId $resourceId, CarbonPeriod $period): ResourceReserved
    {
        return new ResourceReserved(UUID::random(), $resourceId, $period);
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
}
