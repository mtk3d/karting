<?php

declare(strict_types=1);

namespace Karting\Reservation\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ReservationId;

class CancelReservation implements Command
{
    public function __construct(private ReservationId $reservationId)
    {
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }
}
