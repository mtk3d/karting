<?php

declare(strict_types=1);


namespace App\Track;


use App\Availability\Domain\ResourceReserved;

class ResourceReservedListener
{
    public function handle(ResourceReserved $event): void
    {
        /** @var Track $track */
        $track = Track::find((string)$event->resourceId()->id());

        if ($track) {
            $reservation = TrackReservation::of($event->period());
            $track->reservations()->save($reservation);
        }
    }
}
