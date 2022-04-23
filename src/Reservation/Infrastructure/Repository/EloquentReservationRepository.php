<?php

declare(strict_types=1);


namespace Karting\Reservation\Infrastructure\Repository;

use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationRepository;
use Karting\Reservation\Infrastructure\Repository\Eloquent\ReservationModel;
use Karting\Shared\ReservationId;

class EloquentReservationRepository implements ReservationRepository
{
    public function save(Reservation $reservation): void
    {
        $reservation->model()->push();
    }

    public function find(ReservationId $id): Reservation
    {
        $model = ReservationModel::where('uuid', $id->id())->first();
        return new Reservation($model);
    }
}
