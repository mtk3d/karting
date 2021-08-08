<?php

declare(strict_types=1);

namespace Karting\App\ReadModel\ResourceReservation;

use Karting\Availability\Domain\ResourceReserved;

class ResourceReservedListener
{
    public function handle(ResourceReserved $event): void
    {
        $from = $event->period()->getStartDate()->toDateTimeString();
        $to = $event->period()->getEndDate()->toDateTimeString();

        ResourceReservation::create([
            'uuid' => $event->reservationId()->id()->toString(),
            'from' => $from,
            'to' => $to,
            'resource_item_id' => $event->resourceId()->id()->toString()
        ]);
    }
}
