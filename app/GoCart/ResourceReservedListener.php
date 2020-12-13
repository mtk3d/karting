<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceReserved;

class ResourceReservedListener
{
    public function handle(ResourceReserved $event): void
    {
        /** @var GoCart $goCart */
        $goCart = GoCart::find((string)$event->resourceId()->id());

        if ($goCart) {
            $reservation = GoCartReservation::of($event->period());
            $goCart->reservations()->save($reservation);
        }
    }
}
