<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\Reservation;

use Karting\Reservation\Domain\ReservationConfirmed;

class ReservationConfirmedListener
{
    public function handle(ReservationConfirmed $reservationConfirmed): void
    {
        $reservation = Reservation::where('uuid', $reservationConfirmed->reservationId()->id()->toString())->first();
        $reservation->confirmed = true;
        $reservation->save();
    }
}
