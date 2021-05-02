<?php

declare(strict_types=1);


namespace App\Track;

use App\Availability\Domain\ResourceWithdrawn;

class ResourceWithdrawnListener
{
    public function handle(ResourceWithdrawn $event): void
    {
        /** @var Track $track */
        $trackUuid = $event->resourceId()->id()->toString();
        $track = Track::where('uuid', $trackUuid)->first();

        if ($track) {
            $track->is_available = false;
            $track->save();
        }
    }
}
