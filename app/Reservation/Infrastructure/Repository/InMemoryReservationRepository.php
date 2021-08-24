<?php

declare(strict_types=1);


namespace Karting\Reservation\Infrastructure\Repository;

use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\ReservationId;
use Illuminate\Support\Collection;

class InMemoryReservationRepository implements ReservationRepository
{
    private Collection $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function save(Reservation $reservation): void
    {
        $this->items->push($reservation);
    }

    public function find(ReservationId $id): ?Reservation
    {
        return $this->items
            ->first(
                fn (Reservation $reservation): bool => $reservation->id()->isEqual($id)
            );
    }
}
