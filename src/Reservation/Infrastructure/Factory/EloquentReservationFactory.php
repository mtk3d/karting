<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Factory;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationFactory;
use Karting\Reservation\Domain\Status;
use Karting\Reservation\Infrastructure\Repository\Eloquent\ReservationModel;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;

class EloquentReservationFactory extends ReservationFactory
{
    public function from(ReservationId $reservationId, Collection $kartsIds, ResourceId $trackId, CarbonPeriod $period): Reservation
    {
        return new Reservation(new ReservationModel([
            'uuid' => $reservationId,
            'karts' => $this->createKarts($kartsIds),
            'track' => $this->createTrack($trackId),
            'period' => $period,
            'status' => Status::IN_PROGRESS()
        ]));
    }
}
