<?php

declare(strict_types=1);


namespace Karting\Reservation\Domain;

use Karting\Shared\ResourceId;

interface ReservationRepository
{
    public function save(Reservation $reservation): void;

    public function findByGoCartId(ResourceId $resourceId): Reservation;

    public function findByTrackId(ResourceId $resourceId): Reservation;

    public function find(ReservationId $id): Reservation;
}
