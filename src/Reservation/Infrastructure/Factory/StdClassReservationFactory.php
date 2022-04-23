<?php

declare(strict_types=1);

namespace Karting\Reservation\Infrastructure\Factory;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Reservation\Domain\Reservation;
use Karting\Reservation\Domain\ReservationFactory;
use Karting\Reservation\Domain\Status;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use stdClass;

class StdClassReservationFactory extends ReservationFactory
{
    public function from(ReservationId $reservationId, Collection $kartsIds, ResourceId $trackId, CarbonPeriod $period): Reservation
    {
        $model = new stdClass();
        $model->uuid = $reservationId;
        $model->karts = $this->createKarts($kartsIds);
        $model->track = $this->createTrack($trackId);
        $model->period = $period;
        $model->status = Status::IN_PROGRESS();

        return new Reservation($model);
    }
}
