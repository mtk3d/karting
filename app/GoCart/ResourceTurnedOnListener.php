<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceTurnedOn;

class ResourceTurnedOnListener
{
    public function handle(ResourceTurnedOn $event): void
    {
        /** @var GoCart $goCart */
        $goCart = GoCart::find((string)$event->resourceId()->id());

        if ($goCart) {
            $goCart->is_available = true;
            $goCart->save();
        }
    }
}
