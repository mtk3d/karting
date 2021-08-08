<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\ResourceId;

class Kart extends ResourceItem
{
    public static function fromArray(array $payload): Kart
    {
        return new Kart(ResourceId::of($payload['resource_id']), $payload['reserved']);
    }
}
