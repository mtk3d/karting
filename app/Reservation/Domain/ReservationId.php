<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\Common\UUID;
use Karting\Shared\ResourceId;

class ReservationId
{
    private UUID $id;

    public function __construct(UUID $id)
    {
        $this->id = $id;
    }

    public static function of(string $id): ReservationId
    {
        return new ReservationId(new UUID($id));
    }

    public function id(): UUID
    {
        return $this->id;
    }

    public static function newOne(): self
    {
        return new self(UUID::random());
    }

    public function isEqual(self $id): bool
    {
        return $this->id->isEqual($id->id);
    }

    public function __toString()
    {
        return sprintf('ReservationId{id=%s}', $this->id);
    }
}
