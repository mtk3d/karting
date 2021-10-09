<?php

declare(strict_types=1);

namespace App\ReadModel\Reservation;

use App\ReadModel\Kart\Kart;
use Karting\Reservation\Domain\ReservationCreated;

class ReservationCreatedListener
{
    public function handle(ReservationCreated $reservationCreated): void
    {
        $reservation = Reservation::create([
            'uuid' => $reservationCreated->reservationId()->id()->toString(),
            'track_id' => $reservationCreated->track()->id(),
            'from' => $reservationCreated->period()->getStartDate()->toDateTimeString(),
            'to' => $reservationCreated->period()->getEndDate()->toDateTimeString(),
            'status' => $reservationCreated->status()
        ]);

        $karts = Kart::whereIn('uuid', $reservationCreated->karts())->get();

        $reservation->karts()->attach($karts);
    }
}
