<?php

declare(strict_types=1);

namespace Karting\Shared;

use Karting\Shared\Common\UUID;

class ReservationId extends AbstractId
{
    public static function of(string $id): ReservationId
    {
        return new ReservationId(new UUID($id));
    }

    public static function newOne(): ReservationId
    {
        return new ReservationId(UUID::random());
    }

    public function isEqual(ReservationId $id): bool
    {
        return $this->id->isEqual($id->id());
    }
}
