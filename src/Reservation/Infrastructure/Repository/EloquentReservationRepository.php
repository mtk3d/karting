<?php

declare(strict_types=1);


namespace Karting\Reservation\Infrastructure\Repository;

use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\ReservationId;

class EloquentReservationRepository implements ReservationRepository
{
    public function save(Reservation $reservation): void
    {
        $reservation->push();
    }

    public function find(ReservationId $id): ?Reservation
    {
        return Reservation::where('uuid', $id->id())->first();
    }
}
