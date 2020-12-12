<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Listener;

use App\Availability\Application\ReservationService;
use App\GoCart\GoCartCreated;

class GoCartCreatedListener
{
    private ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function handle(GoCartCreated $event): void
    {
        $this->reservationService->createResource($event->resourceId());
    }
}
