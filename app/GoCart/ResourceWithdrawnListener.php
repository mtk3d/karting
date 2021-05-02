<?php

declare(strict_types=1);


namespace App\GoCart;

use App\Availability\Domain\ResourceWithdrawn;

class ResourceWithdrawnListener
{
    public function handle(ResourceWithdrawn $event): void
    {
        /** @var GoCart $goCart */

        $goCartId = $event->resourceId()->id();
        $goCart = GoCart::where(
            'uuid',
            $goCartId->toString()
        )->first();

        if ($goCart) {
            $goCart->is_available = false;
            $goCart->save();
        }
    }
}
