<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceTurnedOn;

class ResourceTurnedOnListener
{
    public function handle(ResourceTurnedOn $event): void
    {
        /** @var GoCart $goCart */

        $goCartId = $event->resourceId()->id();
        $goCart = GoCart::where(
            'uuid',
            $goCartId->toString()
        )->first();

        if ($goCart) {
            $goCart->is_available = true;
            $goCart->save();
        }
    }
}
