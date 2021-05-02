<?php

declare(strict_types=1);


namespace App\Reservation\Domain;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;
}
