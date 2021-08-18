<?php

declare(strict_types=1);

namespace Karting\Availability\Application\Command;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Shared\Common\Command;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;

class ReserveResources implements Command
{
    /**
     * @param Collection<int, ResourceId> $ids
     */
    public function __construct(
        private Collection $ids,
        private CarbonPeriod $period,
        private ReservationId $reservationId
    ) {
    }

    /**
     * @param string[] $ids
     */
    public static function fromRaw(array $ids, string $from, string $to, string $reservationId): ReserveResources
    {
        $ids = (new Collection($ids))->map([ResourceId::class, 'of']);
        $period = CarbonPeriod::create($from, $to);
        $reservationId = ReservationId::of($reservationId);

        return new ReserveResources($ids, $period, $reservationId);
    }

    /**
     * @return Collection<int, ResourceId>
     */
    public function ids(): Collection
    {
        return $this->ids;
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
