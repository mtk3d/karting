<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceReserved;

class ResourceReservedListener
{
    public function handle(ResourceReserved $event): void
    {
        /** @var GoCart $goCart */

        $goCartId = $event->resourceId()->id();
        $goCart = GoCart::where(
            'uuid',
            $goCartId->toString()
        )->first();

        if ($goCart) {
            $reservation = GoCartReservation::of($event->period());
            $goCart->reservations()->save($reservation);
        }
    }
}
