<?php

declare(strict_types=1);


namespace Karting\Availability\Application\Command;

use Karting\Shared\Common\Command;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;
use Carbon\CarbonPeriod;

class ReserveResource implements Command
{
    public function __construct(
        private ResourceId $id,
        private CarbonPeriod $period,
        private ReservationId $reservationId
    ) {
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
