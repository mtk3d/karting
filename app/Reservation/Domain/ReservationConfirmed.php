<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;

class ReservationConfirmed implements DomainEvent
{
    private UUID $id;
    private ReservationId $reservationId;

    public function __construct(UUID $id, ReservationId $reservationId)
    {
        $this->id = $id;
        $this->reservationId = $reservationId;
    }

    public static function newOne(ReservationId $reservationId): self
    {
        return new self(UUID::random(), $reservationId);
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }
}
