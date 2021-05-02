<?php

declare(strict_types=1);


namespace App\Reservation\Infrastructure\Repository;

use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\ReservationRepository;

class InMemoryReservationRepository implements ReservationRepository
{
    public function save(Reservation $reservation): void
    {
        // TODO: Implement save() method.
    }
}
