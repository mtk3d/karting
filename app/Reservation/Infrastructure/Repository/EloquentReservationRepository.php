<?php

declare(strict_types=1);


namespace Karting\Reservation\Infrastructure\Repository;

use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationId;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Shared\ResourceId;

class EloquentReservationRepository implements ReservationRepository
{
    public function save(Reservation $reservation): void
    {
        // TODO: Implement save() method.
    }

    public function findByGoCartId(ResourceId $resourceId): Reservation
    {
        // TODO: Implement findByGoCartId() method.
    }

    public function findByTrackId(ResourceId $resourceId): Reservation
    {
        // TODO: Implement findByTrackId() method.
    }

    public function find(ReservationId $id): Reservation
    {
        // TODO: Implement find() method.
    }
}
