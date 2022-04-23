<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;

abstract class ReservationFactory
{
    /**
     * @param Collection<int, ResourceId> $kartsIds
     */
    abstract public function from(
        ReservationId $reservationId,
        Collection $kartsIds,
        ResourceId $trackId,
        CarbonPeriod $period
    ): Reservation;

    protected function createTrack(ResourceId $trackId): Track
    {
        return new Track($trackId, false);
    }

    /**
     * @param Collection<int, ResourceId> $cartsIds
     * @return Collection<int, Kart>
     */
    protected function createKarts(Collection$cartsIds): Collection
    {
        return $cartsIds->map(fn (ResourceId $id): Kart => new Kart($id, false));
    }
}
