<?php

declare(strict_types=1);


namespace Karting\Reservation\Infrastructure\Repository;

use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationId;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\ResourceId;
use Illuminate\Support\Collection;

class InMemoryReservationRepository implements ReservationRepository
{
    /** @var Collection */
    private Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function save(Reservation $reservation): void
    {
        $this->items->push($reservation);
    }

    public function findByGoCartId(ResourceId $resourceId): Reservation
    {
        return $this->items
            ->first(
                fn (Reservation $reservation): bool => $reservation->kartIds()->contains($resourceId)
            );
    }

    public function findByTrackId(ResourceId $resourceId): Reservation
    {
        return $this->items
            ->first(
                fn (Reservation $reservation): bool => $reservation->trackId()->isEqual($resourceId)
            );
    }

    public function find(ReservationId $id): Reservation
    {
        return $this->items
            ->first(
                fn (Reservation $reservation): bool => $reservation->id()->isEqual($id)
            );
    }
}
