<?php

declare(strict_types=1);


namespace App\Track;


use App\Availability\Domain\ResourceReserved;

class ResourceReservedListener
{
    public function handle(ResourceReserved $event): void
    {
        /** @var Track $track */
        $id = $event->resourceId()->id()->toString();
        $track = Track::where('uuid', $id)->first();

        if ($track) {
            $reservation = TrackReservation::of($event->period());
            $track->reservations()->save($reservation);
        }
    }
}
