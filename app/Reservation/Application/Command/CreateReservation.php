<?php

declare(strict_types=1);

namespace Karting\Reservation\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class CreateReservation implements Command
{
    public function __construct(
        private ReservationId $reservationId,
        private Collection $kartsIds,
        private ResourceId $trackId,
        private CarbonPeriod $period
    ) {
    }

    public static function fromArray(array $payload): CreateReservation
    {
        return new CreateReservation(
            ReservationId::of($payload['uuid']),
            collect($payload['karts_ids'])->map([ResourceId::class, 'of']),
            ResourceId::of($payload['track_id']),
            new CarbonPeriod($payload['from'], $payload['to'])
        );
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }

    public function kartIds(): Collection
    {
        return $this->kartsIds;
    }

    public function trackId(): ResourceId
    {
        return $this->trackId;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }
}
