<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Karting\Reservation\Domain\ReservationStatusChanged;

class ReservationStatusListener
{
    public function handle(ReservationStatusChanged $reservationStatusChanged): void
    {
        $uuid = $reservationStatusChanged->reservationId()->id()->toString();
        $reservation = Reservation::where('uuid', $uuid)->first();
        $reservation->status = $reservationStatusChanged->status();
        $reservation->save();
    }
}
