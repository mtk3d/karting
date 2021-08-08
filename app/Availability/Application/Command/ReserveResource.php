<?php

declare(strict_types=1);


namespace Karting\Availability\Application\Command;

use Karting\Reservation\Domain\ReservationId;
use Karting\Shared\Common\Command;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ReserveResource implements Command
{
    private ResourceId $id;
    private CarbonPeriod $period;
    private ReservationId $reservationId;

    public function __construct(ResourceId $id, CarbonPeriod $period, ReservationId $reservationId)
    {
        $this->id = $id;
        $this->period = $period;
        $this->reservationId = $reservationId;
    }

    public static function fromRaw(string $id, string $from, string $to, string $reservationId): ReserveResource
    {
        $id = ResourceId::of($id);
        $period = CarbonPeriod::create($from, $to);
        $reservationId = ReservationId::of($reservationId);

        return new ReserveResource($id, $period, $reservationId);
    }

    public function id(): ResourceId
    {
        return $this->id;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }
}
