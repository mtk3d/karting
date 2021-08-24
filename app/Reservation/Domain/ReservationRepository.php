<?php

declare(strict_types=1);


namespace Karting\Reservation\Domain;

use Karting\Shared\ReservationId;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;

    public function find(ReservationId $id): ?Reservation;
}
