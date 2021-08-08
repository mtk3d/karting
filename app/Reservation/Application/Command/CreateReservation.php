<?php

declare(strict_types=1);

namespace Karting\Reservation\Application\Command;

use Karting\Reservation\Domain\ReservationId;
use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class CreateReservation implements Command
{
    private ReservationId $reservationId;
    private Collection $goCartIds;
    private ResourceId $trackId;
    private CarbonPeriod $period;

    public function __construct(
        ReservationId $reservationId,
        Collection $goCartIds,
        ResourceId $trackId,
        CarbonPeriod $period
    ) {
        $this->reservationId = $reservationId;
        $this->goCartIds = $goCartIds;
        $this->trackId = $trackId;
        $this->period = $period;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }

    public function kartIds(): Collection
    {
        return $this->goCartIds;
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
