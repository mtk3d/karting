<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceWithdrawn;

class ResourceWithdrawnListener
{
    public function handle(ResourceWithdrawn $event): void
    {
        /** @var GoCart $goCart */
        $goCart = GoCart::find((string)$event->resourceId()->id());

        if ($goCart) {
            $goCart->is_available = false;
            $goCart->save();
        }
    }
}
