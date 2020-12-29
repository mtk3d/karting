<?php

declare(strict_types=1);


namespace App\Track;


use App\Availability\Domain\ResourceTurnedOn;

class ResourceTurnedOnListener
{
    public function handle(ResourceTurnedOn $event): void
    {
        /** @var Track $track */
        $track = Track::find((string)$event->resourceId()->id());

        if ($track) {
            $track->is_available = true;
            $track->save();
        }
    }
}
