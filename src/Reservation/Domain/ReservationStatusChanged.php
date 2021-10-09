<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\Common\DomainEvent;
use Karting\Shared\Common\UUID;
use Karting\Shared\ReservationId;

class ReservationStatusChanged implements DomainEvent
{
    public function __construct(
        private UUID $id,
        private ReservationId $reservationId,
        private string $status
    ) {
    }

    public static function newOne(ReservationId $reservationId, Status $status): self
    {
        return new self(UUID::random(), $reservationId, $status->getValue());
    }

    public function eventId(): UUID
    {
        return $this->id;
    }

    public function reservationId(): ReservationId
    {
        return $this->reservationId;
    }

    public function status(): string
    {
        return $this->status;
    }
}
