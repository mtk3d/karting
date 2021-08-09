<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;
use Karting\Shared\ResourceId;

class ReservationCreated implements DomainEvent
{
    private UUID $id;
    private ReservationId $reservationId;
    /** @var Collection<int, ResourceId> */
    private Collection $karts;
    private ResourceId $track;
    private CarbonPeriod $period;

    public function __construct(UUID $id, ReservationId $reservationId, Collection $karts, ResourceId $track, CarbonPeriod $period)
    {
        $this->id = $id;
        $this->reservationId = $reservationId;
        $this->karts = $karts;
        $this->track = $track;
        $this->period = $period;
    }

    public static function newOne(ReservationId $reservationId, Collection $karts, ResourceId $track, CarbonPeriod $period): self
    {
        return new self(UUID::random(), $reservationId, $karts, $track, $period);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }

    /**
     * @return Collection<int, ResourceId>
     */
    public function karts(): Collection
    {
        return $this->karts;
    }

    public function track(): ResourceId
    {
        return $this->track;
    }

    public function period(): CarbonPeriod
    {
        return $this->period;
    }
}