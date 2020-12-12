<?php

declare(strict_types=1);


namespace App\Availability\Application;

use App\Availability\Domain\ResourceId;
use Carbon\CarbonPeriod;

class AvailabilityFacade
{
    /**
     * @var ReservationService
     */
    private ReservationService $reservationService;
    /**
     * @var AvailabilityService
     */
    private AvailabilityService $availabilityService;

    public function __construct(ReservationService $reservationService, AvailabilityService $availabilityService)
    {
        $this->reservationService = $reservationService;
        $this->availabilityService = $availabilityService;
    }

    public function createResource(ResourceId $resourceId): void
    {
        $this->availabilityService->createResource($resourceId);
    }

    public function turnOnResource(ResourceId $resourceId): void
    {
        $this->availabilityService->turnOnResource($resourceId);
    }

    public function withdrawResource(ResourceId $resourceId): void
    {
        $this->availabilityService->withdrawResource($resourceId);
    }

    public function reserve(ResourceId $id, CarbonPeriod $period): void
    {
        $this->reservationService->reserve($id, $period);
    }
}
