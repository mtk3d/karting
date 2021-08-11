<?php

declare(strict_types=1);

namespace Karting\Shared;

use Karting\Shared\Common\UUID;

class ReservationId
{
    public function __construct(private UUID $id)
    {
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

    public function __toString(): string
    {
        return sprintf('ReservationId{id=%s}', $this->id);
    }
}
