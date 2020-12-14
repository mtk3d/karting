<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Listener;

use App\Availability\Application\AvailabilityService;
use App\Availability\Application\ReservationService;
use App\GoCart\GoCartCreated;

class GoCartCreatedListener
{
    private AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function handle(GoCartCreated $event): void
    {
        $this->availabilityService->createResource($event->resourceId(), $event->isAvailable());
    }
}
