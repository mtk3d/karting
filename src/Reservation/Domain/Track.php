<?php

declare(strict_types=1);

namespace Karting\Reservation\Domain;

use Karting\Shared\ResourceId;

class Track extends ResourceItem
{
    public static function fromArray(array $payload): Track
    {
        return new Track(ResourceId::of($payload['resource_id']), $payload['reserved']);
    }
}
