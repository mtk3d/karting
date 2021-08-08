<?php

declare(strict_types=1);

namespace Karting\Reservation\Application\Command;

use Karting\Reservation\Domain\ReservationId;
use Karting\Shared\Common\Command;

class AcceptReservation implements Command
{
    private ReservationId $reservationId;

    public function __construct(ReservationId $reservationId)
    {
        $this->reservationId = $reservationId;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }
}
